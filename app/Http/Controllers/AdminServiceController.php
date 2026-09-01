<?php

namespace App\Http\Controllers;

use App\Models\ServiceInvoice;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Services\ServiceNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| پروسرویس — نظارت ادمین
|--------------------------------------------------------------------------
|
| ادمین همه‌ی خرابی‌ها رو می‌بینه، براشون فاکتور می‌زنه (با درصد کمیسیون
| و فعال/غیرفعال کردن بیمه)، و در صورت نیاز تکنسین رو عوض می‌کنه.
|
*/

class AdminServiceController extends Controller
{
    public function __construct(
        private ServiceNotifier $notifier,
    ) {
    }


    public function index(Request $request)
    {
        $query = ServiceRequest::with(['customer', 'technician', 'invoice'])->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        return view('admin.service.index', [
            'requests' => $query->get(),
            'statuses' => ServiceRequest::LABELS,
            'currentStatus' => $status ?? null,
        ]);
    }


    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['customer', 'technician', 'invoice.items', 'statusLogs']);

        return view('admin.service.show', [
            'serviceRequest' => $serviceRequest,
            'technicians'    => Technician::where('is_active', true)->orderBy('name')->get(),
        ]);
    }


    /**
     * صدور یا ویرایش فاکتور. فقط تا قبل از تایید نهایی مشتری (confirmed)
     * قابل ویرایشه، چون بعدش پول واریز شده و دیگه نباید تغییر کنه.
     */
    public function saveInvoice(Request $request, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status === 'confirmed') {
            return back()->with('error', 'این خرابی قبلاً تسویه شده و فاکتورش قابل تغییر نیست.');
        }

        $validated = $request->validate([
            'commission_percent' => 'required|integer|min:0|max:100',
            'has_insurance'      => 'nullable|boolean',
            'items'              => 'required|array|min:1',
            'items.*.title'      => 'required|string|max:255',
            'items.*.amount'     => 'required|integer|min:0',
        ], [], [
            'commission_percent' => 'درصد کمیسیون',
            'items'              => 'ردیف‌های فاکتور',
        ]);

        $invoice = $serviceRequest->invoice ?: new ServiceInvoice([
            'service_request_id' => $serviceRequest->id,
            'created_by'         => Auth::id(),
        ]);

        $invoice->commission_percent = $validated['commission_percent'];
        $invoice->created_by = $invoice->created_by ?: Auth::id();
        $invoice->save();

        $invoice->items()->delete();

        foreach ($validated['items'] as $item) {
            $invoice->items()->create([
                'title'  => $item['title'],
                'amount' => $item['amount'],
            ]);
        }

        $invoice->recalculate();

        $serviceRequest->update(['has_insurance' => $request->boolean('has_insurance')]);

        if ($serviceRequest->status === 'reported') {
            $serviceRequest->moveTo('invoiced', 'فاکتور توسط مدیر صادر شد.');
            $this->notifier->invoiced($serviceRequest, (int) $invoice->subtotal);
        }

        return redirect()
            ->route('admin.service.show', $serviceRequest)
            ->with('success', 'فاکتور ذخیره شد.');
    }


    /**
     * تخصیص یا تعویض دستی تکنسین توسط ادمین (مثلاً وقتی تکنسین اختصاصی
     * مشتری در دسترس نیست).
     */
    public function assignTechnician(Request $request, ServiceRequest $serviceRequest)
    {
        if (in_array($serviceRequest->status, ['confirmed', 'cancelled'], true)) {
            return back()->with('error', 'این خرابی بسته شده و قابل تغییر نیست.');
        }

        $validated = $request->validate([
            'technician_id' => 'required|exists:technicians,id',
        ]);

        $technician = Technician::findOrFail($validated['technician_id']);

        $wasAssigned = (bool) $serviceRequest->technician_id;

        $serviceRequest->update(['technician_id' => $technician->id]);

        $serviceRequest->moveTo(
            $wasAssigned ? $serviceRequest->status : 'assigned',
            'تکنسین توسط مدیر به «' . $technician->name . '» تغییر کرد.'
        );

        $this->notifier->technicianAssigned($serviceRequest->fresh('technician'));

        return back()->with('success', 'تکنسین تنظیم شد.');
    }


    public function cancel(ServiceRequest $serviceRequest)
    {
        if (in_array($serviceRequest->status, ['confirmed', 'cancelled'], true)) {
            return back()->with('error', 'این خرابی قابل لغو نیست.');
        }

        $serviceRequest->moveTo('cancelled', 'توسط مدیر لغو شد.');

        $this->notifier->requestCancelled($serviceRequest);

        return back()->with('success', 'خرابی لغو شد.');
    }
}
