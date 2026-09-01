<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [

        'user_id',
        'name',
        'mobile',
        'phone',
        'province',
        'city',
        'address',
        'dedicated_technician_id',

    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function dedicatedTechnician(): BelongsTo
    {
        return $this->belongsTo(Technician::class, 'dedicated_technician_id');
    }


    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
