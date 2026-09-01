<?php

namespace App\Console\Commands;

use App\Models\MaintenanceVisit;
use App\Models\ServiceContract;
use App\Services\ServiceContractService;
use App\Services\ServiceNotifier;
use Illuminate\Console\Command;


/**
 * کارهای روزانه‌ی قراردادهای پرو سرویس:
 *
 *   ۱) قراردادهایی که تاریخشان گذشته را منقضی می‌کند
 *   ۲) بازدیدهای دوره‌ای عقب‌افتاده را «انجام نشد» می‌کند
 *   ۳) یادآوری بازدید امروز به تکنسین
 *   ۴) یادآوری تمدید به مشتری
 *
 * روزی یک بار کافی است — همه‌ی این‌ها دقت روز دارند نه دقیقه.
 */
class RunServiceContractsDaily extends Command
{
    protected $signature = 'proservice:daily';

    protected $description = 'انقضای قراردادها، یادآوری بازدید دوره‌ای و تمدید';


    public function handle(ServiceContractService $contracts, ServiceNotifier $notifier): int
    {
        $expired = $contracts->expireDue();

        $this->info("{$expired} قرارداد منقضی شد.");


        /*
        | بازدیدی که موعدش گذشته و هنوز ثبت نشده، «انجام نشد» می‌شود.
        | یک روز مهلت می‌دهیم تا تکنسینی که همان روز کار کرده ولی شب
        | ثبت می‌کند، بی‌دلیل missed نخورد.
        */
        $missed = MaintenanceVisit::where('status', 'due')
            ->whereDate('due_on', '<', now()->subDay()->toDateString())
            ->update(['status' => 'missed']);

        $this->info("{$missed} بازدید دوره‌ای انجام‌نشده ثبت شد.");


        $dueToday = MaintenanceVisit::with(['technician', 'contract.building'])
            ->where('status', 'due')
            ->whereDate('due_on', now()->toDateString())
            ->get();

        foreach ($dueToday as $visit) {
            $notifier->visitDue($visit);
        }

        $this->info("{$dueToday->count()} یادآوری بازدید ارسال شد.");


        $days = (int) config('proservice.renewal_reminder_days', 14);

        $renewing = ServiceContract::with('building.customer')
            ->where('status', 'active')
            ->whereDate('ends_at', now()->addDays($days)->toDateString())
            ->get();

        foreach ($renewing as $contract) {
            $notifier->renewalDue($contract, $days);
        }

        $this->info("{$renewing->count()} یادآوری تمدید ارسال شد.");

        return self::SUCCESS;
    }
}
