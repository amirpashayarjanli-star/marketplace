<?php

namespace App\Filament\Admin\Resources\Manufacturers\Tables;

use App\Filament\Admin\Support\DirectoryProfile;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ManufacturersTable
{
    public static function configure(Table $table): Table
    {
        return DirectoryProfile::table($table, [

            TextColumn::make('manager_name')
                ->label('مدیر')
                ->placeholder('—')
                ->searchable(),

            TextColumn::make('products_count')
                ->label('محصول')
                ->placeholder('۰'),

        ]);
    }
}
