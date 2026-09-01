<?php

namespace App\Filament\Admin\Resources\Stores\Schemas;

use App\Filament\Admin\Support\DirectoryProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StoreForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components(DirectoryProfile::formSections([

            TextInput::make('manager_name')
                ->label('نام مدیر')
                ->maxLength(255),

            TextInput::make('email')
                ->label('ایمیل')
                ->email()
                ->maxLength(255),

            TextInput::make('website')
                ->label('وب‌سایت')
                ->url()
                ->maxLength(255),

        ]));
    }
}
