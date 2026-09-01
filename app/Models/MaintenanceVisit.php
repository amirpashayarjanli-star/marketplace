<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * یک بازدید دوره‌ای برنامه‌ریزی‌شده روی قرارداد سرویس دوره‌ای.
 *
 * status: due (موعد) | done (انجام شد) | missed (از دست رفت)
 */
class MaintenanceVisit extends Model
{
    public const STATUS_LABELS = [
        'due'    => 'در انتظار انجام',
        'done'   => 'انجام شد',
        'missed' => 'انجام نشد',
    ];


    protected $fillable = [

        'service_contract_id',
        'technician_id',
        'due_on',
        'status',
        'done_at',
        'report',
        'customer_rating',

    ];


    protected function casts(): array
    {
        return [
            'due_on'  => 'date',
            'done_at' => 'datetime',
        ];
    }


    public function contract(): BelongsTo
    {
        return $this->belongsTo(ServiceContract::class, 'service_contract_id');
    }


    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }


    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }


    public function isOverdue(): bool
    {
        return $this->status === 'due' && $this->due_on->isPast();
    }
}
