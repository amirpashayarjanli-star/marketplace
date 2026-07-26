<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Employer extends Model
{

    protected $fillable = [

        'name',
        'slug',
        'mobile',
        'phone',
        'email',
        'province',
        'city',
        'address',
        'description',
        'is_verified',
        'is_active',

    ];





    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

}
