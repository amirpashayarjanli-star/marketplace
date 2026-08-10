<?php

namespace App\Models;


use Database\Factories\UserFactory;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;



/**
 * @property int $id
 * @property string $name
 * @property string|null $mobile
 * @property string|null $email
 * @property string|null $type
 * @property string|null $status
 * @property string|null $role
 * @property Carbon|null $email_verified_at
 * @property string $password
 */
#[Fillable([

    'name',

    'mobile',

    'email',

    'type',

    'status',

    'role',

    'password',

])]

#[Hidden([

    'password',

    'remember_token',

])]

class User extends Authenticatable
{


    use HasFactory, Notifiable;



    protected function casts(): array
    {

        return [

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

        ];

    }




    public function company()
    {

        return $this->hasOne(Company::class);

    }



    public function manufacturer()
    {

        return $this->hasOne(Manufacturer::class);

    }



    public function store()
    {

        return $this->hasOne(Store::class);

    }



    public function technician()
    {

        return $this->hasOne(Technician::class);

    }



    public function employer()
    {

        return $this->hasOne(Employer::class);

    }





    public function initials(): string
    {

        $initials = Str::initials($this->name, true);


        return Str::length($initials) > 1

            ? Str::substr($initials, 0, 1)
                .Str::substr($initials, -1)

            : $initials;

    }


}
