<?php

namespace App\Filament\Admin\Resources\Wallets\Tables;

use App\Models\User;
use App\Models\Wallet;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WalletsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('balance', 'desc')

            ->columns([

                TextColumn::make('user.name')
                    ->label('کاربر')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('user.mobile')
                    ->label('موبایل')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('user.type')
                    ->label('نوع حساب')
                    ->badge()
                    ->placeholder('—')
                    ->formatStateUsing(fn ($state) => User::TYPES[$state] ?? $state),

                TextColumn::make('balance')
                    ->label('موجودی')
                    ->formatStateUsing(fn ($state) => number_format((int) $state) . ' تومان')
                    ->sortable(),

                TextColumn::make('transactions_count')
                    ->label('تراکنش')
                    ->counts('transactions'),

                TextColumn::make('updated_at')
                    ->label('آخرین تغییر')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('type')
                    ->label('نوع حساب')
                    ->options(User::TYPES)
                    ->query(fn (Builder $query, array $data) => filled($data['value'] ?? null)
                        ? $query->whereHas('user', fn (Builder $q) => $q->where('type', $data['value']))
                        : $query),

                Filter::make('has_balance')
                    ->label('فقط موجودی‌دار')
                    ->query(fn (Builder $query) => $query->where('balance', '>', 0)),

            ])

            // کلیک روی هر ردیف، دفتر تراکنش‌های همان کیف‌پول را باز می‌کند.
            ->recordUrl(fn (Wallet $record) => route('filament.admin.resources.wallets.view', $record));
    }
}
