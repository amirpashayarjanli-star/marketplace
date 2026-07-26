<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Company extends Model
{

    protected $fillable = [

        'name',
        'slug',
        'manager_name',
        'mobile',
        'phone',
        'email',
        'website',
        'province',
        'city',
        'address',
        'logo',
        'cover',
        'description',
        'rating',
        'reviews_count',
        'experience',
        'projects_count',
        'is_verified',
        'is_active',

    ];





    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }





    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
