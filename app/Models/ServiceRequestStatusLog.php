<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequestStatusLog extends Model
{
    public $timestamps = false;

    protected $fillable = [

        'service_request_id',
        'status',
        'note',
        'created_at',

    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }


    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
