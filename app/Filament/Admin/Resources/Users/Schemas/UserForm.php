<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('نام')
                    ->maxLength(255),

                TextInput::make('mobile')
                    ->label('موبایل')
                    ->tel()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('ورود با کد پیامکی روی همین شماره انجام می‌شود.'),

                TextInput::make('email')
                    ->label('ایمیل')
                    ->email()
                    ->unique(ignoreRecord: true),

                Select::make('type')
                    ->label('نوع حساب')
                    ->options(User::TYPES)
                    ->helperText('عوض کردن این مقدار پروفایل قبلی را جابه‌جا نمی‌کند.'),

                Select::make('status')
                    ->label('وضعیت')
                    ->options(User::STATUSES)
                    ->required(),

                Select::make('role')
                    ->label('نقش')
                    ->options(User::ROLES)
                    ->default('user')
                    ->required()
                    ->helperText('نقش «مدیر سیستم» دسترسی کامل به همین پنل می‌دهد.'),

            ]);
    }
}
