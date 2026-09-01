<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| پروسرویس — سمت مشتری
|--------------------------------------------------------------------------
|
| ثبت خرابی، انتخاب تکنسین، پیگیری وضعیت، و در پایان تایید تحویل و رضایت.
| پول فقط همون‌جا (confirm) به کیف پول تکنسین واریز میشه، نه زودتر.
|
*/

class ServiceRequestController extends Controller
{
    private function customerOrAbort()
    {
        $user = Auth::user();

        if ($user->type !== 'customer' || ! $user->customer) {
            abort(404);
        }

        return $user->customer;
    }


    public function index()
    {
        $customer = $this->customerOrAbort();

        $requests = $customer->serviceRequests()
            ->with(['technician', 'invoice'])
            ->latest()
            ->get();

        return view('service.index', [
            'customer' => $customer,
            'requests' => $requests,
        ]);
    }


    public function create()
    {
        $customer = $this->customerOrAbort();

        return view('service.create', [
            'customer'  => $customer,
            'buildings' => $customer->buildings()
                ->with(['elevators', 'activeContract'])
                ->get(),
        ]);
    }


    public function store(Request $request)
    {
        $customer = $this->customerOrAbort();

        $validated = $request->validate([
            'description' => 'required|string|min:15|max:1000',
            'address'     => 'nullable|string|max:500',
            'building_id' => 'nullable|integer|exists:buildings,id',
            'elevator_id' => 'nullable|integer|exists:elevators,id',
        ], [], [
            'description' => 'شرح خرابی',
            'address'     => 'نشانی',
            'building_id' => 'پرونده',
            'elevator_id' => 'دستگاه',
        ]);

        /*
        | خرابی می‌تواند زیر یک پرونده ثبت شود یا آزاد بماند (مشتری‌ای
        | که هنوز پرونده نساخته). اگر پرونده داده شده باشد باید مال
        | همین مشتری باشد، و قرارداد فعالش روی خرابی snapshot می‌شود.
        */
        $building = null;
        $contract = null;

        if (! empty($validated['building_id'])) {

            $building = $customer->buildings()
                ->with('activeContract')
                ->findOrFail($validated['building_id']);

            $contract = $building->activeContract;
        }

        $elevatorId = null;

        if ($building && ! empty($validated['elevator_id'])) {
            $elevatorId = $building->elevators()
                ->whereKey($validated['elevator_id'])
                ->value('id');
        }

        $serviceRequest = ServiceRequest::create([
            'customer_id'         => $customer->id,
            'building_id'         => $building?->id,
            'elevator_id'         => $elevatorId,
            'service_contract_id' => $contract?->id,
            // قرارداد دوره‌ای خرابی‌های معمول را پوشش می‌دهد؛ سرویس
            // موردی هر بار فاکتور جداگانه دارد.
            'covered_by_contract' => (bool) $contract?->isPeriodic(),
            'description'         => $validated['description'],
            'address'             => $validated['address']
                ?: ($building?->fullAddress() ?: $customer->address),
        ]);

        $serviceRequest->moveTo('reported', 'خرابی توسط مشتری ثبت شد.');

        return redirect()
            ->route('service.show', $serviceRequest)
            ->with('success', 'خرابی شما ثبت شد. به‌زودی فاکتور برایتان صادر می‌شود.');
    }


    public function show(ServiceRequest $serviceRequest)
    {
        $customer = $this->customerOrAbort();

        if ($serviceRequest->customer_id !== $customer->id) {
            abort(403);
        }

        $serviceRequest->load(['technician', 'invoice.items', 'statusLogs']);

        $technicians = null;

        if ($serviceRequest->status === 'invoiced') {
            $technicians = Technician::where('is_active', true)
                ->where('is_verified', true)
                ->orderByDesc('rating')
                ->get();
        }

        return view('service.show', [
            'customer'        => $customer,
            'serviceRequest'  => $serviceRequest,
            'technicians'     => $technicians,
        ]);
    }


    /**
     * انتخاب تکنسین برای این خرابی — یا از لیست، یا همون تکنسین اختصاصی.
     */
    public function chooseTechnician(Request $request, ServiceRequest $serviceRequest)
    {
        $customer = $this->customerOrAbort();

        if ($serviceRequest->customer_id !== $customer->id) {
            abort(403);
        }

        if ($serviceRequest->status !== 'invoiced') {
            return back()->with('error', 'در این مرحله نمی‌توانید تکنسین انتخاب کنید.');
        }

        $validated = $request->validate([
            'technician_id'  => 'required|exists:technicians,id',
            'make_dedicated' => 'nullable|boolean',
        ]);

        $technician = Technician::findOrFail($validated['technician_id']);

        $serviceRequest->update(['technician_id' => $technician->id]);
        $serviceRequest->moveTo('assigned', 'تکنسین «' . $technician->name . '» انتخاب شد.');

        if ($request->boolean('make_dedicated')) {
            $customer->update(['dedicated_technician_id' => $technician->id]);
        }

        return redirect()
            ->route('service.show', $serviceRequest)
            ->with('success', 'تکنسین انتخاب شد و منتظر پذیرش او هستیم.');
    }


    /**
     * تایید نهایی مشتری: کار تحویل گرفته شد و رضایت دارم.
     * تنها جایی که پول واقعاً به کیف پول تکنسین واریز میشه.
     */
    public function confirm(Request $request, ServiceRequest $serviceRequest)
    {
        $customer = $this->customerOrAbort();

        if ($serviceRequest->customer_id !== $customer->id) {
            abort(403);
        }

        if ($serviceRequest->status !== 'completed') {
            return back()->with('error', 'کار هنوز توسط تکنسین تکمیل اعلام نشده است.');
        }

        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ], [], [
            'rating' => 'امتیاز',
            'feedback' => 'نظر',
        ]);

        $invoice = $serviceRequest->invoice;

        if (! $invoice) {
            return back()->with('error', 'فاکتوری برای این خرابی ثبت نشده است.');
        }

        // همه یا هیچ‌کدوم — نباید وضعیت «تایید شد» ثبت بشه ولی واریز به
        // کیف پول تکنسین به هر دلیلی انجام نشه.
        \Illuminate\Support\Facades\DB::transaction(function () use ($serviceRequest, $invoice, $validated) {

            $serviceRequest->update([
                'customer_rating'   => $validated['rating'],
                'customer_feedback' => $validated['feedback'] ?? null,
                'confirmed_at'      => now(),
            ]);

            $serviceRequest->moveTo('confirmed', 'مشتری تحویل و رضایت خود را تایید کرد.');

            $wallet = \App\Models\Wallet::forUser($serviceRequest->technician->user);

            $wallet->credit(
                $invoice->technician_amount,
                'تسویه‌ی خرابی #' . $serviceRequest->id,
                $serviceRequest->id
            );

            $invoice->update(['paid_at' => now()]);

        });

        return redirect()
            ->route('service.show', $serviceRequest)
            ->with('success', 'از رضایت شما متشکریم. مبلغ به کیف پول تکنسین واریز شد.');
    }
}
