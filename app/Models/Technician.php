<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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





    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }





    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }


}
