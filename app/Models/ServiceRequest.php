<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceRequest extends Model
{
    // ترتیب همین آرایه، ترتیب نمایش مراحل توی timeline مشتریه
    public const STATUSES = [
        'reported',
        'invoiced',
        'assigned',
        'accepted',
        'on_the_way',
        'arrived',
        'in_progress',
        'completed',
        'confirmed',
    ];

    public const LABELS = [
        'reported'    => 'ثبت شده — منتظر فاکتور',
        'invoiced'    => 'فاکتور صادر شد — منتظر انتخاب تکنسین',
        'assigned'    => 'تکنسین مشخص شد — منتظر پذیرش',
        'accepted'    => 'تکنسین پذیرفت',
        'on_the_way'  => 'تکنسین در راه است',
        'arrived'     => 'تکنسین رسید',
        'in_progress' => 'در حال تعمیر',
        'completed'   => 'کار تمام شد — منتظر تایید شما',
        'confirmed'   => 'تایید و تسویه شد',
        'cancelled'   => 'لغو شده',
    ];

    // مراحلی که خودِ تکنسین با یک کلیک جلو می‌بره (پس از پذیرش)
    public const TECHNICIAN_STAGES = [
        'accepted',
        'on_the_way',
        'arrived',
        'in_progress',
        'completed',
    ];


    protected $fillable = [

        'customer_id',
        'technician_id',
        'status',
        'description',
        'address',
        'has_insurance',
        'customer_rating',
        'customer_feedback',
        'completed_at',
        'confirmed_at',

    ];


    protected function casts(): array
    {
        return [
            'has_insurance' => 'boolean',
            'completed_at'  => 'datetime',
            'confirmed_at'  => 'datetime',
        ];
    }


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }


    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }


    public function invoice(): HasOne
    {
        return $this->hasOne(ServiceInvoice::class);
    }


    public function statusLogs(): HasMany
    {
        return $this->hasMany(ServiceRequestStatusLog::class)->orderBy('created_at');
    }


    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }


    public function label(): string
    {
        return self::LABELS[$this->status] ?? $this->status;
    }


    /**
     * وضعیت رو عوض می‌کنه و توی timeline ثبتش می‌کنه — این تنها راه درست
     * برای تغییر وضعیته، مستقیم ->update(['status'=>...]) نزن.
     */
    public function moveTo(string $status, ?string $note = null): void
    {
        $this->update(['status' => $status]);

        $this->statusLogs()->create([
            'status'     => $status,
            'note'       => $note,
            'created_at' => now(),
        ]);
    }
}
