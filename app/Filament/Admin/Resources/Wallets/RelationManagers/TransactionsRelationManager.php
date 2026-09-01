<?php

namespace App\Filament\Admin\Resources\Wallets\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/*
| دفتر تراکنش‌ها فقط خواندنی است — این‌ها سند مالی‌اند و ویرایششان
| موجودی را با تاریخچه ناهماهنگ می‌کند.
*/
class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    protected static ?string $title = 'تراکنش‌ها';


    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('نوع')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'credit' ? 'واریز' : 'برداشت')
                    ->color(fn ($state) => $state === 'credit' ? 'success' : 'danger'),

                TextColumn::make('amount')
                    ->label('مبلغ')
                    ->formatStateUsing(fn ($state) => number_format((int) $state) . ' تومان'),

                TextColumn::make('description')
                    ->label('بابت')
                    ->wrap()
                    ->limit(80),

            ])

            ->filters([

                SelectFilter::make('type')
                    ->label('نوع')
                    ->options([
                        'credit' => 'واریز',
                        'debit'  => 'برداشت',
                    ]),

            ]);
    }
}
