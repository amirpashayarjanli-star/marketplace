<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'description',
        'is_verified',
        'is_active',
    ];
}