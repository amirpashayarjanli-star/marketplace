<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

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
