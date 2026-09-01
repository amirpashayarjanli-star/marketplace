<?php

namespace App\Filament\Admin\Resources\Companies\Tables;

use App\Filament\Admin\Support\DirectoryProfile;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return DirectoryProfile::table($table, [

            TextColumn::make('manager_name')
                ->label('مدیر')
                ->placeholder('—')
                ->searchable(),

            TextColumn::make('services_count')
                ->label('خدمات')
                ->counts('services'),

        ]);
    }
}
