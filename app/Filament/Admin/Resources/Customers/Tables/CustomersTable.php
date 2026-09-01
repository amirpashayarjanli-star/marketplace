<?php

namespace App\Filament\Admin\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('name')
                    ->label('نام')
                    ->searchable(),

                TextColumn::make('mobile')
                    ->label('موبایل')
                    ->searchable()
                    ->copyable()
                    ->placeholder('—'),

                TextColumn::make('city')
                    ->label('شهر')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('buildings_count')
                    ->label('پرونده')
                    ->counts('buildings'),

                TextColumn::make('service_requests_count')
                    ->label('خرابی')
                    ->counts('serviceRequests'),

                TextColumn::make('dedicatedTechnician.name')
                    ->label('تکنسین ثابت')
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('ثبت')
                    ->dateTime('Y/m/d')
                    ->sortable(),

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
