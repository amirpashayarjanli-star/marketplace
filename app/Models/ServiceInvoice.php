<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceInvoice extends Model
{
    protected $fillable = [

        'service_request_id',
        'created_by',
        'subtotal',
        'commission_percent',
        'commission_amount',
        'technician_amount',
        'paid_at',

    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
        ];
    }


    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }


    public function items(): HasMany
    {
        return $this->hasMany(ServiceInvoiceItem::class);
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * از روی ردیف‌های فاکتور، subtotal/commission/سهم تکنسین رو حساب و ذخیره می‌کنه.
     */
    public function recalculate(): void
    {
        $subtotal = $this->items()->sum('amount');
        $commissionAmount = (int) round($subtotal * $this->commission_percent / 100);

        $this->update([
            'subtotal'          => $subtotal,
            'commission_amount' => $commissionAmount,
            'technician_amount' => $subtotal - $commissionAmount,
        ]);
    }
}
