<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * بیمه‌نامه‌ی واقعی صادرشده برای یک قرارداد. مقادیر را ادمین از روی
 * بیمه‌نامه‌ی شرکت بیمه وارد می‌کند.
 */
class InsurancePolicy extends Model
{
    protected $fillable = [

        'service_contract_id',
        'insurer',
        'policy_no',
        'coverage_amount',
        'starts_at',
        'ends_at',
        'document_path',
        'notes',

    ];


    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'ends_at'   => 'date',
        ];
    }


    public function contract(): BelongsTo
    {
        return $this->belongsTo(ServiceContract::class, 'service_contract_id');
    }


    public function isValid(): bool
    {
        return ! $this->starts_at->isFuture() && ! $this->ends_at->isPast();
    }


    /** آیا به انقضا نزدیک شده؟ */
    public function isExpiringSoon(): bool
    {
        $days = (int) config('proservice.insurance_expiry_warning_days', 30);

        return $this->isValid()
            && now()->startOfDay()->diffInDays($this->ends_at, false) <= $days;
    }
}
