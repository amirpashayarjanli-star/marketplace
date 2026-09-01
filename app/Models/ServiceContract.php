<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * قرارداد سرویس روی یک پرونده.
 *
 * قیمت در لحظه‌ی قیمت‌گذاری snapshot می‌شود (monthly_fee، months،
 * discount_percent، elevator_count)، پس تغییر بعدی نرخ‌های config
 * روی قراردادهای بسته‌شده اثری ندارد.
 */
class ServiceContract extends Model
{
    public const STATUS_LABELS = [
        'pending_review'   => 'در انتظار بررسی و قیمت‌گذاری',
        'awaiting_payment' => 'در انتظار پرداخت',
        'active'           => 'فعال',
        'expired'          => 'منقضی شده',
        'cancelled'        => 'لغو شده',
    ];


    protected $fillable = [

        'building_id',
        'code',
        'plan',
        'term',
        'status',
        'technician_mode',
        'technician_id',
        'elevator_count',
        'monthly_fee',
        'months',
        'discount_percent',
        'total_amount',
        'visits_per_month',
        'starts_at',
        'ends_at',
        'paid_at',
        'cancelled_at',
        'cancel_reason',
        'admin_note',

    ];


    protected function casts(): array
    {
        return [
            'starts_at'    => 'date',
            'ends_at'      => 'date',
            'paid_at'      => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }


    protected static function booted(): void
    {
        static::creating(function (self $contract) {
            $contract->code ??= sprintf('C-%d-%04d', (int) jdate(now(), 'Y'), static::max('id') + 1);
        });
    }


    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }


    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }


    public function visits(): HasMany
    {
        return $this->hasMany(MaintenanceVisit::class)->orderBy('due_on');
    }


    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }


    public function policies(): HasMany
    {
        return $this->hasMany(InsurancePolicy::class)->latest('ends_at');
    }


    /** بیمه‌نامه‌ای که همین حالا معتبر است. */
    public function activePolicy(): HasOne
    {
        return $this->hasOne(InsurancePolicy::class)
            ->where('starts_at', '<=', now()->toDateString())
            ->where('ends_at', '>=', now()->toDateString())
            ->latestOfMany('ends_at');
    }


    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }


    public function planLabel(): string
    {
        return config("proservice.plans.{$this->plan}.label", $this->plan);
    }


    public function termLabel(): string
    {
        return config("proservice.terms.{$this->term}.label", $this->term);
    }


    public function technicianModeLabel(): string
    {
        return config("proservice.technician_modes.{$this->technician_mode}", $this->technician_mode);
    }


    public function isPeriodic(): bool
    {
        return $this->plan === 'periodic';
    }


    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->ends_at
            && ! $this->ends_at->isPast();
    }


    /** چند روز تا پایان قرارداد مانده — منفی یعنی گذشته. */
    public function daysLeft(): ?int
    {
        return $this->ends_at
            ? (int) now()->startOfDay()->diffInDays($this->ends_at, false)
            : null;
    }


    /**
     * قیمت را از روی config حساب می‌کند و روی مدل می‌نشاند. تا وقتی
     * ذخیره نشده، هیچ چیز snapshot نمی‌شود.
     */
    public function priceFromConfig(int $elevatorCount): self
    {
        $plan = config("proservice.plans.{$this->plan}");
        $term = config("proservice.terms.{$this->term}");

        $this->elevator_count   = max(1, $elevatorCount);
        $this->monthly_fee      = (int) ($plan['monthly_fee'] ?? 0);
        $this->months           = (int) ($term['months'] ?? 1);
        $this->discount_percent = (int) ($term['discount_percent'] ?? 0);
        $this->visits_per_month = (int) ($plan['visits_per_month'] ?? 0);

        $gross = $this->monthly_fee * $this->months * $this->elevator_count;

        $this->total_amount = (int) round($gross * (100 - $this->discount_percent) / 100);

        return $this;
    }
}
