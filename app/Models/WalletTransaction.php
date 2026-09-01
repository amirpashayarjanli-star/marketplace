<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [

        'wallet_id',
        'type',
        'amount',
        'description',
        'service_request_id',
        'bid_id',

    ];


    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }


    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }


    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }
}
