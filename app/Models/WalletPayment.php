<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class WalletPayment extends Model
{

    protected $fillable = [

        'user_id',
        'amount',
        'gateway',
        'authority',
        'ref_id',
        'card_pan',
        'status',
        'message',
        'wallet_transaction_id',
        'paid_at',

    ];


    protected $casts = [
        'amount'  => 'integer',
        'paid_at' => 'datetime',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function walletTransaction(): BelongsTo
    {
        return $this->belongsTo(WalletTransaction::class);
    }


    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
