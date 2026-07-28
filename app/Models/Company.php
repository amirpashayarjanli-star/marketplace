<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;


    protected $fillable = [

        'name',
        'slug',
        'manager_name',
        'mobile',
        'phone',
        'website',
        'city',
        'address',
        'logo',
        'cover',
        'description',
        'rating',
        'reviews_count',
        'experience',
        'projects_count',
        'is_active',

    ];



    protected $casts = [

        'is_active' => 'boolean',
        'rating' => 'float',

    ];



    public function projects()
    {
        return $this->hasMany(Project::class);
    }



    public function reviews()
    {
        return $this->morphMany(
            Review::class,
            'reviewable'
        );
    }



    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->withTimestamps();
    }
}
