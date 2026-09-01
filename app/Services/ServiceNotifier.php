<?php

namespace App\Services;

use App\Models\MaintenanceVisit;
use App\Models\ServiceContract;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Log;

/**
 * پیامک‌های پرو سرویس.
 *
 * هیچ‌کدام از این پیامک‌ها نباید جریان کار را بشکنند — اگر پنل پیامک
 * پاسخ ندهد، تغییر وضعیت باید انجام شده باشد. برای همین هر ارسال در
 * try/catch است و خطا فقط لاگ می‌شود.
 */
class ServiceNotifier
{
    public function __construct(
        private SmsService $sms,
    ) {
    }


    private function send(?string $mobile, string $text): void
    {
        if (blank($mobile)) {
            return;
        }

        try {
            $this->sms->send($mobile, $text);
        } catch (\Throwable $e) {
            Log::warning('ارسال پیامک پرو سرویس ناموفق بود', [
                'mobile' => $mobile,
                'error'  => $e->getMessage(),
            ]);
        }
    }


    private function customerMobile(ServiceRequest $request): ?string
    {
        return $request->customer->mobile ?: $request->customer->user?->mobile;
    }


    private function technicianMobile(ServiceRequest $request): ?string
    {
        return $request->technician?->mobile ?: $request->technician?->user?->mobile;
    }


    /** خرابی جدید ثبت شد — به مدیران خبر بده تا فاکتور بزنند. */
    public function requestCreated(ServiceRequest $request): void
    {
        $admins = array_filter(explode(',', (string) env('PROSERVICE_ADMIN_MOBILES', '')));

        foreach ($admins as $mobile) {
            $this->send(trim($mobile), sprintf(
                'آسانسور پرو: خرابی جدید #%d از %s ثبت شد.',
                $request->id,
                $request->customer->name,
            ));
        }
    }


    /** فاکتور صادر شد — مشتری باید تکنسین انتخاب کند. */
    public function invoiced(ServiceRequest $request, int $amount): void
    {
        $this->send($this->customerMobile($request), sprintf(
            'آسانسور پرو: فاکتور خرابی #%d به مبلغ %s تومان صادر شد. برای انتخاب تکنسین وارد پنل شوید.',
            $request->id,
            number_format($amount),
        ));
    }


    /** تکنسین انتخاب/تعیین شد — هر دو طرف باید بدانند. */
    public function technicianAssigned(ServiceRequest $request): void
    {
        $this->send($this->customerMobile($request), sprintf(
            'آسانسور پرو: تکنسین %s برای خرابی #%d انتخاب شد. منتظر پذیرش او هستیم.',
            $request->technician?->name,
            $request->id,
        ));

        $this->send($this->technicianMobile($request), sprintf(
            'آسانسور پرو: کار جدید #%d به شما ارجاع شد. برای پذیرش وارد پنل شوید.',
            $request->id,
        ));
    }


    /**
     * تکنسین وضعیت را جلو برد. فقط مرحله‌هایی که برای مشتری خبر
     * واقعی‌اند پیامک می‌شوند — نه همه‌ی تغییرها.
     */
    public function stageAdvanced(ServiceRequest $request, string $stage): void
    {
        $messages = [
            'accepted'   => 'تکنسین %s درخواست #%d شما را پذیرفت.',
            'on_the_way' => 'تکنسین %s برای خرابی #%d در راه است.',
            'completed'  => 'تکنسین %s کار خرابی #%d را تمام‌شده اعلام کرد. لطفاً تحویل را تایید کنید.',
        ];

        if (! isset($messages[$stage])) {
            return;
        }

        $this->send($this->customerMobile($request), 'آسانسور پرو: ' . sprintf(
            $messages[$stage],
            $request->technician?->name,
            $request->id,
        ));
    }


    /** مشتری تحویل را تایید کرد — تکنسین پولش را گرفته. */
    public function settled(ServiceRequest $request, int $technicianAmount): void
    {
        $this->send($this->technicianMobile($request), sprintf(
            'آسانسور پرو: خرابی #%d تایید شد و %s تومان به کیف‌پول شما واریز شد.',
            $request->id,
            number_format($technicianAmount),
        ));
    }


    public function requestCancelled(ServiceRequest $request): void
    {
        $this->send($this->technicianMobile($request), sprintf(
            'آسانسور پرو: خرابی #%d لغو شد.',
            $request->id,
        ));
    }


    /** قرارداد قیمت خورد و منتظر پرداخت است. */
    public function contractQuoted(ServiceContract $contract): void
    {
        $this->send($contract->building->customer->mobile, sprintf(
            'آسانسور پرو: قرارداد %s قیمت‌گذاری شد. مبلغ %s تومان. برای پرداخت وارد پنل شوید.',
            $contract->code,
            number_format($contract->total_amount),
        ));
    }


    public function contractActivated(ServiceContract $contract): void
    {
        $this->send($contract->building->customer->mobile, sprintf(
            'آسانسور پرو: قرارداد %s برای «%s» فعال شد و تا %s اعتبار دارد.',
            $contract->code,
            $contract->building->title,
            jdate($contract->ends_at),
        ));
    }


    /** یادآوری بازدید دوره‌ای به تکنسین. */
    public function visitDue(MaintenanceVisit $visit): void
    {
        $this->send($visit->technician?->mobile, sprintf(
            'آسانسور پرو: بازدید دوره‌ای «%s» در تاریخ %s موعدش رسیده است.',
            $visit->contract->building->title,
            jdate($visit->due_on),
        ));
    }


    /** یادآوری تمدید قرارداد به مشتری. */
    public function renewalDue(ServiceContract $contract, int $daysLeft): void
    {
        $this->send($contract->building->customer->mobile, sprintf(
            'آسانسور پرو: قرارداد %s برای «%s» تا %d روز دیگر تمام می‌شود. برای تمدید وارد پنل شوید.',
            $contract->code,
            $contract->building->title,
            $daysLeft,
        ));
    }
}
