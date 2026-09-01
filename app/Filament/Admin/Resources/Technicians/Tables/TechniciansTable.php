<?php

namespace App\Filament\Admin\Resources\Technicians\Tables;

use App\Filament\Admin\Support\DirectoryProfile;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TechniciansTable
{
    public static function configure(Table $table): Table
    {
        return DirectoryProfile::table($table, [

            TextColumn::make('experience')
                ->label('سابقه')
                ->placeholder('—')
                ->suffix(' سال'),

            TextColumn::make('repairs_count')
                ->label('تعمیرها')
                ->placeholder('۰'),

        ]);
    }
}
