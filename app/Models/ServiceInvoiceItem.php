<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceInvoiceItem extends Model
{
    protected $fillable = [

        'service_invoice_id',
        'title',
        'amount',

    ];


    public function invoice(): BelongsTo
    {
        return $this->belongsTo(ServiceInvoice::class, 'service_invoice_id');
    }
}
