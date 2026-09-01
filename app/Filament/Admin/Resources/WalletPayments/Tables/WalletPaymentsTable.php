<?php

namespace App\Filament\Admin\Resources\WalletPayments\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WalletPaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('کاربر')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('user.mobile')
                    ->label('موبایل')
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('مبلغ')
                    ->formatStateUsing(fn ($state) => number_format((int) $state) . ' تومان')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'paid'     => 'موفق',
                        'pending'  => 'در جریان',
                        'failed'   => 'ناموفق',
                        'canceled' => 'انصراف',
                        default    => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'paid'    => 'success',
                        'pending' => 'warning',
                        default   => 'danger',
                    }),

                TextColumn::make('ref_id')
                    ->label('کد پیگیری')
                    ->placeholder('—')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('card_pan')
                    ->label('کارت')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('paid_at')
                    ->label('زمان پرداخت')
                    ->dateTime('Y/m/d H:i')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'paid'     => 'موفق',
                        'pending'  => 'در جریان',
                        'failed'   => 'ناموفق',
                        'canceled' => 'انصراف',
                    ]),

            ]);
    }
}
