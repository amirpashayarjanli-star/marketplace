<?php

namespace App\Filament\Admin\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/*
| خدمات همان چیزهایی‌اند که شرکت‌ها در پروفایلشان تیک می‌زنند
| (جدول واسط company_service)، پس ستون «شرکت» تعداد انتخاب‌کننده‌هاست.
*/
class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name')

            ->columns([

                TextColumn::make('name')
                    ->label('خدمت')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('توضیحات')
                    ->limit(70)
                    ->placeholder('—')
                    ->wrap(),

                TextColumn::make('companies_count')
                    ->label('شرکت')
                    ->counts('companies'),

                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),

            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
