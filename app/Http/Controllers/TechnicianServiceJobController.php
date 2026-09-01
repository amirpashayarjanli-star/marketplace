<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceVisit;
use App\Models\ServiceRequest;
use App\Services\ServiceNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| پروسرویس — سمت تکنسین
|--------------------------------------------------------------------------
|
| کارهایی که به این تکنسین تخصیص داده شده، و پیش‌بردن مرحله‌به‌مرحله‌شون.
|
*/

class TechnicianServiceJobController extends Controller
{
    public function __construct(
        private ServiceNotifier $notifier,
    ) {
    }


    // ترتیب دقیقاً باید همینی باشه که تکنسین یکی‌یکی طی می‌کنه
    private const NEXT_STAGE = [
        'assigned'    => 'accepted',
        'accepted'    => 'on_the_way',
        'on_the_way'  => 'arrived',
        'arrived'     => 'in_progress',
        'in_progress' => 'completed',
    ];

    private const STAGE_NOTE = [
        'accepted'    => 'تکنسین درخواست را پذیرفت.',
        'on_the_way'  => 'تکنسین در راه است.',
        'arrived'     => 'تکنسین به محل رسید.',
        'in_progress' => 'تعمیر شروع شد.',
        'completed'   => 'تکنسین کار را تمام‌شده اعلام کرد.',
    ];


    private function technicianOrAbort()
    {
        $user = Auth::user();

        if ($user->type !== 'technician' || ! $user->technician) {
            abort(404);
        }

        return $user->technician;
    }


    public function index()
    {
        $technician = $this->technicianOrAbort();

        $jobs = $technician->serviceRequests()
            ->with(['customer', 'invoice'])
            ->whereNotIn('status', ['confirmed', 'cancelled'])
            ->latest()
            ->get();

        $history = $technician->serviceRequests()
            ->with(['customer', 'invoice'])
            ->whereIn('status', ['confirmed', 'cancelled'])
            ->latest()
            ->limit(20)
            ->get();

        /*
        | بازدیدهای دوره‌ای هم کارِ همین تکنسین‌اند ولی چرخه‌ی وضعیت
        | خرابی را ندارند — یک‌بار «انجام شد» می‌خورند و تمام.
        */
        $visits = MaintenanceVisit::with('contract.building')
            ->where('technician_id', $technician->id)
            ->where('status', 'due')
            ->orderBy('due_on')
            ->get();

        return view('service.jobs.index', [
            'technician' => $technician,
            'jobs'       => $jobs,
            'history'    => $history,
            'visits'     => $visits,
        ]);
    }


    public function show(ServiceRequest $serviceRequest)
    {
        $technician = $this->technicianOrAbort();

        if ($serviceRequest->technician_id !== $technician->id) {
            abort(403);
        }

        $serviceRequest->load(['customer', 'invoice.items', 'statusLogs']);

        return view('service.jobs.show', [
            'technician'     => $technician,
            'serviceRequest' => $serviceRequest,
            'nextStage'      => self::NEXT_STAGE[$serviceRequest->status] ?? null,
        ]);
    }


    public function advance(ServiceRequest $serviceRequest)
    {
        $technician = $this->technicianOrAbort();

        if ($serviceRequest->technician_id !== $technician->id) {
            abort(403);
        }

        $next = self::NEXT_STAGE[$serviceRequest->status] ?? null;

        if (! $next) {
            return back()->with('error', 'در این مرحله کاری برای پیش‌بردن نیست.');
        }

        $serviceRequest->moveTo($next, self::STAGE_NOTE[$next]);

        if ($next === 'completed') {
            $serviceRequest->update(['completed_at' => now()]);
        }

        $this->notifier->stageAdvanced($serviceRequest, $next);

        return redirect()
            ->route('service.jobs.show', $serviceRequest)
            ->with('success', 'وضعیت به‌روزرسانی شد.');
    }


    /**
     * ثبت انجام یک بازدید دوره‌ای توسط تکنسین.
     */
    public function completeVisit(Request $request, MaintenanceVisit $visit)
    {
        $technician = $this->technicianOrAbort();

        if ($visit->technician_id !== $technician->id) {
            abort(403);
        }

        if ($visit->status !== 'due') {
            return back()->with('error', 'این بازدید قبلاً ثبت شده است.');
        }

        $validated = $request->validate([
            'report' => 'required|string|min:5|max:1000',
        ], [], ['report' => 'گزارش بازدید']);

        $visit->update([
            'status'  => 'done',
            'report'  => $validated['report'],
            'done_at' => now(),
        ]);

        return back()->with('success', 'بازدید ثبت شد.');
    }
}
