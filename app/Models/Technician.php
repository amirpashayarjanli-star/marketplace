<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Traits\HasSlug;


class Technician extends Model
{

    use HasSlug;

    protected $fillable = [

        'user_id',
        'name',
        'slug',
        'avatar',
        'mobile',
        'phone',
        'skills',
        'province',
        'city',
        'address',
        'description',
        'experience',
        'projects_count',
        'repairs_count',
        'rating',
        'reviews_count',
        'is_verified',
        'is_active',

    ];





    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }




    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }




    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }




    public function dedicatedCustomers(): HasMany
    {
        return $this->hasMany(Customer::class, 'dedicated_technician_id');
    }





    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }


}
