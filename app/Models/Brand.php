<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Brand extends Model
{

    use HasSlug;


    protected $fillable = [

        'name',
        'slug',
        'logo',
        'description',
        'is_verified',
        'is_active',

    ];





    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
