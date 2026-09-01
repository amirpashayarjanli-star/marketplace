<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
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

        return view('service.jobs.index', [
            'technician' => $technician,
            'jobs'       => $jobs,
            'history'    => $history,
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

        return redirect()
            ->route('service.jobs.show', $serviceRequest)
            ->with('success', 'وضعیت به‌روزرسانی شد.');
    }
}
