<?php

namespace App\Filament\Admin\Resources\Technicians\Schemas;

use App\Filament\Admin\Support\DirectoryProfile;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TechnicianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components(DirectoryProfile::formSections([

            TextInput::make('experience')
                ->label('سابقه (سال)')
                ->numeric()
                ->minValue(0)
                ->maxValue(80),

            Textarea::make('skills')
                ->label('تخصص‌ها')
                ->rows(2)
                ->columnSpanFull()
                ->helperText('مثلاً: تعمیر درب، تابلو فرمان، کابین'),

        ]));
    }
}
