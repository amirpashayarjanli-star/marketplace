<?php

namespace App\Services;

use App\Models\Building;
use App\Models\MaintenanceVisit;
use App\Models\ServiceContract;
use App\Models\Wallet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * چرخه‌ی عمر قرارداد سرویس.
 *
 * منطق پول و برنامه‌ی بازدیدها اینجا جمع است تا کنترلرها فقط
 * اعتبارسنجی و مسیریابی داشته باشند.
 */
class ServiceContractService
{
    /**
     * مشتری درخواست قرارداد می‌دهد. قیمت را همین‌جا از config حساب
     * می‌کنیم تا مشتری قبل از تایید ادمین هم عدد ببیند، ولی قرارداد
     * تا قیمت‌گذاری/تایید ادمین به awaiting_payment نمی‌رود.
     */
    public function request(
        Building $building,
        string $plan,
        string $term,
        string $technicianMode,
        ?int $technicianId = null,
    ): ServiceContract {

        $contract = new ServiceContract([
            'building_id'     => $building->id,
            'plan'            => $plan,
            'term'            => $term,
            'status'          => 'pending_review',
            'technician_mode' => $technicianMode,
            'technician_id'   => $technicianMode === 'dedicated' ? $technicianId : null,
        ]);

        $contract->priceFromConfig($building->elevators()->count());

        $contract->save();

        return $contract;
    }


    /**
     * ادمین قیمت را نهایی می‌کند و قرارداد را می‌فرستد برای پرداخت.
     */
    public function quote(ServiceContract $contract, int $monthlyFee, ?string $note = null): ServiceContract
    {
        $gross = $monthlyFee * $contract->months * $contract->elevator_count;

        $contract->update([
            'monthly_fee'  => $monthlyFee,
            'total_amount' => (int) round($gross * (100 - $contract->discount_percent) / 100),
            'admin_note'   => $note,
            'status'       => 'awaiting_payment',
        ]);

        return $contract;
    }


    /**
     * پرداخت از کیف‌پول و فعال‌سازی. اگر قرارداد دوره‌ای باشد، برنامه‌ی
     * بازدیدها همین‌جا ساخته می‌شود.
     *
     * همه یا هیچ — نباید پول کسر شود ولی قرارداد فعال نشود.
     *
     * @throws \App\Exceptions\InsufficientWalletBalanceException
     */
    public function activateFromWallet(ServiceContract $contract): ServiceContract
    {
        return DB::transaction(function () use ($contract) {

            $user = $contract->building->customer->user;

            Wallet::forUser($user)->debit(
                $contract->total_amount,
                'قرارداد سرویس ' . $contract->code . ' — ' . $contract->building->title,
            );

            $starts = Carbon::today();

            $contract->update([
                'status'    => 'active',
                'paid_at'   => now(),
                'starts_at' => $starts,
                'ends_at'   => $starts->copy()->addMonths($contract->months),
            ]);

            if ($contract->isPeriodic()) {
                $this->scheduleVisits($contract);
            }

            return $contract;

        });
    }


    /**
     * بازدیدهای دوره‌ای را برای کل مدت قرارداد می‌سازد.
     *
     * فاصله‌ی بازدیدها از visits_per_month می‌آید: ۱ در ماه یعنی هر ۳۰
     * روز، ۲ در ماه یعنی هر ۱۵ روز. تکنسین همانِ قرارداد است؛ در حالت
     * assigned خالی می‌ماند تا ادمین بگذارد.
     */
    public function scheduleVisits(ServiceContract $contract): int
    {
        $perMonth = max(0, (int) $contract->visits_per_month);

        if ($perMonth === 0) {
            return 0;
        }

        $total = $perMonth * $contract->months;
        $step  = (int) round(30 / $perMonth);

        $due = $contract->starts_at->copy();

        $made = 0;

        for ($i = 0; $i < $total; $i++) {

            $due->addDays($step);

            if ($due->greaterThan($contract->ends_at)) {
                break;
            }

            MaintenanceVisit::create([
                'service_contract_id' => $contract->id,
                'technician_id'       => $contract->technician_id,
                'due_on'              => $due->copy(),
                'status'              => 'due',
            ]);

            $made++;
        }

        return $made;
    }


    /**
     * لغو قرارداد. بازدیدهای انجام‌نشده هم بی‌اثر می‌شوند.
     *
     * عمداً پول برنمی‌گردانیم — تسویه‌ی قرارداد لغوشده دستی و با نظر
     * مدیر انجام می‌شود، چون ممکن است بخشی از دوره مصرف شده باشد.
     */
    public function cancel(ServiceContract $contract, ?string $reason = null): ServiceContract
    {
        DB::transaction(function () use ($contract, $reason) {

            $contract->update([
                'status'        => 'cancelled',
                'cancelled_at'  => now(),
                'cancel_reason' => $reason,
            ]);

            $contract->visits()
                ->where('status', 'due')
                ->update(['status' => 'missed']);

        });

        return $contract;
    }


    /**
     * قراردادهایی که تاریخشان گذشته را منقضی می‌کند. از کامند زمان‌بندی
     * صدا زده می‌شود.
     */
    public function expireDue(): int
    {
        return ServiceContract::where('status', 'active')
            ->whereNotNull('ends_at')
            ->whereDate('ends_at', '<', now()->toDateString())
            ->update(['status' => 'expired']);
    }
}
