<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Traits\HasSlug;


class Manufacturer extends Model
{

    use HasSlug;

    protected $fillable = [

        'user_id',
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
        'experience',
        'products_count',
        'customers_count',
        'rating',
        'reviews_count',
        'is_verified',
        'is_active',

    ];





    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }





    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }





    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
