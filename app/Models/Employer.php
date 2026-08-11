<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasSlug;


class Employer extends Model
{

    use HasSlug;

    protected $fillable = [

        'user_id',
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
