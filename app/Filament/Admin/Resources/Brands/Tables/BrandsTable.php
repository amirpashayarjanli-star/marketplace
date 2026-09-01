<?php

namespace App\Filament\Admin\Resources\Brands\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BrandsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name')

            ->columns([

                TextColumn::make('name')
                    ->label('برند')
                    ->searchable(),

                TextColumn::make('products_count')
                    ->label('محصول')
                    ->counts('products'),

                IconColumn::make('is_active')
                    ->label('در سایت')
                    ->boolean(),

                IconColumn::make('is_verified')
                    ->label('تایید شده')
                    ->boolean(),

            ])

            ->filters([

                TernaryFilter::make('is_active')
                    ->label('نمایش در سایت')
                    ->placeholder('همه')
                    ->trueLabel('نمایش داده می‌شود')
                    ->falseLabel('پنهان'),

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
