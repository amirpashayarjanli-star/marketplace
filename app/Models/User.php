<?php

namespace App\Models;


use Database\Factories\UserFactory;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

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

class User extends Authenticatable implements FilamentUser
{


    use HasFactory, Notifiable;



    protected function casts(): array
    {

        return [

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

        ];

    }




    /*
    |--------------------------------------------------------------------------
    | دسترسی به پنل‌های Filament
    |--------------------------------------------------------------------------
    |
    | بدون این متد، Filament در محیط production به همه (حتی خود ادمین) 403
    | می‌دهد و در محیط local برعکس، هر کاربر لاگین‌کرده‌ای می‌تواند وارد پنل شود.
    |
    */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {

            'admin'     => $this->role === 'admin',

            'moderator' => in_array($this->role, ['admin', 'moderator'], true),

            default     => false,

        };
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



    public function customer()
    {

        return $this->hasOne(Customer::class);

    }



    public function wallet()
    {

        return $this->hasOne(Wallet::class);

    }



    public function bids()
    {

        return $this->hasMany(Bid::class);

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
