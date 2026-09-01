<?php

namespace App\Http\Controllers;

use App\Models\InsurancePolicy;
use App\Models\MaintenanceVisit;
use App\Models\ServiceContract;
use App\Models\Technician;
use App\Services\ServiceContractService;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| پرو سرویس — قراردادها از دید ادمین
|--------------------------------------------------------------------------
|
| ادمین قرارداد درخواستی را بررسی و قیمت‌گذاری می‌کند، بیمه‌نامه‌ی صادرشده
| را ثبت می‌کند، و تکنسین بازدیدهای دوره‌ای را مشخص می‌کند.
|
*/

class AdminContractController extends Controller
{
    public function __construct(
        private ServiceContractService $contracts,
    ) {
    }


    public function index(Request $request)
    {
        $query = ServiceContract::with(['building.customer', 'technician'])->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        return view('admin.contracts.index', [
            'contracts'     => $query->get(),
            'statuses'      => ServiceContract::STATUS_LABELS,
            'currentStatus' => $status ?? null,
        ]);
    }


    public function show(ServiceContract $contract)
    {
        $contract->load([
            'building.customer',
            'building.elevators',
            'technician',
            'visits.technician',
            'policies',
        ]);

        return view('admin.contracts.show', [
            'contract'    => $contract,
            'technicians' => Technician::where('is_active', true)->orderBy('name')->get(),
        ]);
    }


    /**
     * قیمت‌گذاری نهایی — قرارداد را به مرحله‌ی پرداخت می‌برد.
     */
    public function quote(Request $request, ServiceContract $contract)
    {
        if (! in_array($contract->status, ['pending_review', 'awaiting_payment'], true)) {
            return back()->with('error', 'این قرارداد در مرحله‌ی قیمت‌گذاری نیست.');
        }

        $validated = $request->validate([
            'monthly_fee' => 'required|integer|min:0',
            'admin_note'  => 'nullable|string|max:500',
        ], [], [
            'monthly_fee' => 'اجاره‌ی ماهانه',
            'admin_note'  => 'یادداشت',
        ]);

        $this->contracts->quote(
            $contract,
            (int) $validated['monthly_fee'],
            $validated['admin_note'] ?? null,
        );

        return back()->with('success', 'قیمت ثبت شد و قرارداد برای پرداخت به مشتری رفت.');
    }


    /**
     * تعیین تکنسین قرارداد. بازدیدهای انجام‌نشده هم به همین تکنسین
     * منتقل می‌شوند، وگرنه برنامه‌ی دوره‌ای بی‌صاحب می‌ماند.
     */
    public function assignTechnician(Request $request, ServiceContract $contract)
    {
        $validated = $request->validate([
            'technician_id' => 'required|exists:technicians,id',
        ], [], ['technician_id' => 'تکنسین']);

        $contract->update([
            'technician_id'   => $validated['technician_id'],
            'technician_mode' => 'dedicated',
        ]);

        $contract->visits()
            ->where('status', 'due')
            ->update(['technician_id' => $validated['technician_id']]);

        return back()->with('success', 'تکنسین قرارداد ثبت شد.');
    }


    /**
     * ثبت بیمه‌نامه‌ی صادرشده. مقادیر از روی بیمه‌نامه‌ی شرکت بیمه وارد
     * می‌شوند — ما بیمه‌نامه صادر نمی‌کنیم، فقط ثبتش می‌کنیم.
     */
    public function storePolicy(Request $request, ServiceContract $contract)
    {
        $validated = $request->validate([
            'insurer'         => 'required|string|max:150',
            'policy_no'       => 'required|string|max:100',
            'coverage_amount' => 'required|integer|min:0',
            'starts_at'       => 'required|date',
            'ends_at'         => 'required|date|after:starts_at',
            'notes'           => 'nullable|string|max:500',
        ], [], [
            'insurer'         => 'شرکت بیمه',
            'policy_no'       => 'شماره بیمه‌نامه',
            'coverage_amount' => 'سقف پوشش',
            'starts_at'       => 'تاریخ شروع',
            'ends_at'         => 'تاریخ پایان',
            'notes'           => 'توضیحات',
        ]);

        $contract->policies()->create($validated);

        return back()->with('success', 'بیمه‌نامه ثبت شد.');
    }


    public function destroyPolicy(ServiceContract $contract, InsurancePolicy $policy)
    {
        abort_if($policy->service_contract_id !== $contract->id, 404);

        $policy->delete();

        return back()->with('success', 'بیمه‌نامه حذف شد.');
    }


    /**
     * ثبت انجام یک بازدید دوره‌ای توسط ادمین (وقتی تکنسین خودش ثبت
     * نکرده باشد).
     */
    public function completeVisit(Request $request, ServiceContract $contract, MaintenanceVisit $visit)
    {
        abort_if($visit->service_contract_id !== $contract->id, 404);

        $validated = $request->validate([
            'report' => 'nullable|string|max:1000',
            'status' => 'required|in:done,missed',
        ], [], [
            'report' => 'گزارش',
            'status' => 'وضعیت',
        ]);

        $visit->update([
            'status'  => $validated['status'],
            'report'  => $validated['report'] ?? null,
            'done_at' => $validated['status'] === 'done' ? now() : null,
        ]);

        return back()->with('success', 'وضعیت بازدید ثبت شد.');
    }


    public function cancel(Request $request, ServiceContract $contract)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:300',
        ], [], ['reason' => 'دلیل']);

        $this->contracts->cancel($contract, $validated['reason'] ?? null);

        return back()->with('success', 'قرارداد لغو شد.');
    }
}
