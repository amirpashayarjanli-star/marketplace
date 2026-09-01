<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{

    use HasSlug;


    protected $fillable = [

        'name',
        'slug',
        'image',
        'category',
        'description',
        'brand_id',
        'manufacturer_id',
        'store_id',
        'is_verified',
        'is_active',

    ];





    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }





    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }





    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

}
