<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    use HasSlug;


    protected $fillable = [

        'name',
        'slug',
        'description',
        'is_active',

    ];



    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

}
