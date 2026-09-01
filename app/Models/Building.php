<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * پرونده‌ی یک ساختمان. قرارداد، بیمه، تکنسین و تاریخچه‌ی خرابی‌ها
 * همه از اینجا آویزان‌اند.
 */
class Building extends Model
{
    protected $fillable = [

        'customer_id',
        'code',
        'title',
        'province',
        'city',
        'address',
        'postal_code',
        'floors',
        'units',
        'manager_name',
        'manager_mobile',
        'notes',

    ];


    protected static function booted(): void
    {
        static::creating(function (self $building) {
            $building->code ??= static::nextCode();
        });
    }


    /**
     * شماره‌ی پرونده: AP-<سال شمسی>-<شمارنده>. شمارنده از id آخرین
     * پرونده می‌آید، پس در شرایط رقابتی ممکن است تکراری شود — ستون
     * unique است و همین محافظ نهایی است.
     */
    public static function nextCode(): string
    {
        $year = (int) jdate(now(), 'Y');

        $seq = static::max('id') + 1;

        return sprintf('AP-%d-%04d', $year, $seq);
    }


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }


    public function elevators(): HasMany
    {
        return $this->hasMany(Elevator::class);
    }


    public function contracts(): HasMany
    {
        return $this->hasMany(ServiceContract::class)->latest();
    }


    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class)->latest();
    }


    /**
     * قرارداد فعال — همانی که خرابی‌های جدید زیرش ثبت می‌شوند.
     */
    public function activeContract(): HasOne
    {
        return $this->hasOne(ServiceContract::class)
            ->where('status', 'active')
            ->where('ends_at', '>=', now()->toDateString())
            ->latestOfMany();
    }


    public function fullAddress(): string
    {
        return trim(implode(' - ', array_filter([
            $this->province,
            $this->city,
            $this->address,
        ])));
    }
}
