<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    protected $fillable = [

        'user_id',
        'balance',

    ];


    /*
    | ستون balance در دیتابیس default(0) دارد، ولی مدلی که همین الان با
    | firstOrCreate ساخته شده این را نمی‌داند و در حافظه null می‌ماند تا
    | وقتی از دیتابیس دوباره خوانده شود. برای کیف‌پولِ تازه یعنی
    | Wallet::forUser($u)->balance مقدار null می‌داد نه صفر.
    */
    protected $attributes = [
        'balance' => 0,
    ];


    protected function casts(): array
    {
        return [
            'balance' => 'integer',
        ];
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class)->latest();
    }


    /**
     * موجودی رو زیاد می‌کنه و تراکنشش رو ثبت می‌کنه — این تنها راه درست
     * برای واریزه، مستقیم ->increment نزن.
     */
    public function credit(int $amount, string $description, ?int $serviceRequestId = null, ?int $bidId = null): WalletTransaction
    {
        return DB::transaction(function () use ($amount, $description, $serviceRequestId, $bidId) {

            $this->increment('balance', $amount);

            return $this->transactions()->create([
                'type'               => 'credit',
                'amount'             => $amount,
                'description'        => $description,
                'service_request_id' => $serviceRequestId,
                'bid_id'             => $bidId,
            ]);

        });
    }


    /**
     * موجودی رو کم می‌کنه و تراکنشش رو ثبت می‌کنه — تنها راه درست برای
     * برداشت. اگر موجودی کافی نباشه استثنا پرتاب می‌کنه، مستقیم
     * ->decrement نزن.
     */
    public function debit(int $amount, string $description, ?int $bidId = null): WalletTransaction
    {
        return DB::transaction(function () use ($amount, $description, $bidId) {

            $wallet = static::whereKey($this->id)->lockForUpdate()->first();

            if ($wallet->balance < $amount) {
                throw new \App\Exceptions\InsufficientWalletBalanceException(
                    'موجودی کیف‌پول کافی نیست.'
                );
            }

            $wallet->decrement('balance', $amount);
            $this->balance = $wallet->balance;

            return $this->transactions()->create([
                'type'        => 'debit',
                'amount'      => $amount,
                'description' => $description,
                'bid_id'      => $bidId,
            ]);
        });
    }


    public static function forUser(User $user): self
    {
        return static::firstOrCreate(['user_id' => $user->id]);
    }
}
