<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * درخواست برداشت از کیف‌پول.
 *
 * مبلغ همان لحظه‌ی ثبت درخواست از کیف‌پول کسر می‌شود تا نشود همان پول
 * را جای دیگری هم خرج کرد؛ رد شدن درخواست آن را برمی‌گرداند.
 */
class WalletWithdrawal extends Model
{
    public const STATUS_LABELS = [
        'pending'  => 'در انتظار بررسی',
        'approved' => 'واریز شد',
        'rejected' => 'رد شد',
    ];


    protected $fillable = [

        'user_id',
        'amount',
        'iban',
        'account_holder',
        'status',
        'reference',
        'admin_note',
        'processed_by',
        'processed_at',

    ];


    protected function casts(): array
    {
        return [
            'processed_at' => 'datetime',
        ];
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }


    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
