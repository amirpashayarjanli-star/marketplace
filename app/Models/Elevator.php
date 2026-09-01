<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * یک دستگاه آسانسور داخل یک پرونده. قیمت قرارداد به تعداد همین‌ها
 * بستگی دارد و خرابی می‌تواند به یک دستگاه مشخص نسبت داده شود.
 */
class Elevator extends Model
{
    protected $fillable = [

        'building_id',
        'label',
        'brand',
        'capacity_kg',
        'stops',
        'install_year',
        'serial_no',
        'notes',

    ];


    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }


    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }


    public function summary(): string
    {
        $parts = array_filter([
            $this->brand,
            $this->capacity_kg ? $this->capacity_kg . ' کیلوگرم' : null,
            $this->stops ? $this->stops . ' توقف' : null,
        ]);

        return $parts ? implode(' · ', $parts) : '—';
    }
}
