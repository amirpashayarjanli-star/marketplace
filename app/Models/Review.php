<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Review extends Model
{

    protected $fillable = [

        'name',
        'comment',
        'rating',
        'reviewable_type',
        'reviewable_id',
        'is_verified',

    ];





    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

}
