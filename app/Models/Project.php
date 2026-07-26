<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Project extends Model
{

    protected $fillable = [

        'title',
        'slug',
        'image',
        'province',
        'city',
        'type',
        'description',
        'employer_id',
        'company_id',
        'technician_id',
        'manufacturer_id',
        'is_verified',
        'is_active',

    ];





    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }





    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }





    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }





    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

}
