<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Bid extends Model
{

    protected $fillable = [

        'auction_id',
        'user_id',
        'amount',
        'delivery_days',
        'description',
        'attachment',
        'status',
        'fee_transaction_id',

    ];


    protected $casts = [
        'amount'        => 'integer',
        'delivery_days' => 'integer',
    ];


    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function feeTransaction(): BelongsTo
    {
        return $this->belongsTo(WalletTransaction::class, 'fee_transaction_id');
    }


    /**
     * کارمزد این پیشنهاد بر اساس درصد مزایده.
     */
    public function feeAmount(): int
    {
        $percent = (float) ($this->auction->fee_percent
            ?? config('proauction.fee_percent', 5));

        return (int) round($this->amount * $percent / 100);
    }
}
