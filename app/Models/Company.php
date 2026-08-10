<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Company extends Model
{

    use HasFactory;



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

        'rating',

        'reviews_count',

        'experience',

        'projects_count',

        'is_verified',

        'is_active',

    ];




    protected $casts = [

        'is_verified' => 'boolean',

        'is_active' => 'boolean',

        'rating' => 'float',

    ];





    protected static function boot()
    {

        parent::boot();


        static::creating(function ($company) {


            if (!$company->slug) {


                $company->slug = Str::slug(
                    $company->name
                );


            }


        });


    }





    public function user()
    {

        return $this->belongsTo(User::class);

    }





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
