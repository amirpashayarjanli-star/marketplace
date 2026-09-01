<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('name')
                    ->label('محصول')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('brand.name')
                    ->label('برند')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('category')
                    ->label('دسته')
                    ->placeholder('—')
                    ->badge(),

                TextColumn::make('store.name')
                    ->label('فروشگاه')
                    ->placeholder('—'),

                TextColumn::make('manufacturer.name')
                    ->label('تولیدکننده')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('در سایت')
                    ->boolean(),

            ])

            ->filters([

                SelectFilter::make('brand_id')
                    ->label('برند')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),

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
