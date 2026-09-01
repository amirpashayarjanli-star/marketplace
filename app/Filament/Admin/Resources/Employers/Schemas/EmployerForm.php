<?php

namespace App\Filament\Admin\Resources\Employers\Schemas;

use App\Filament\Admin\Support\DirectoryProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components(DirectoryProfile::formSections([

            TextInput::make('email')
                ->label('ایمیل')
                ->email()
                ->maxLength(255),

        ]));
    }
}
