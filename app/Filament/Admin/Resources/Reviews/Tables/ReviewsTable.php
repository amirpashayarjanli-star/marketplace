<?php

namespace App\Filament\Admin\Resources\Reviews\Tables;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\TernaryFilter;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('نام کاربر')
                    ->searchable(),

                TextColumn::make('comment')
                    ->label('نظر')
                    ->limit(60)
                    ->wrap(),

                TextColumn::make('rating')
                    ->label('امتیاز'),

                BadgeColumn::make('is_verified')
                    ->label('وضعیت')
                    ->formatStateUsing(fn ($state) => $state ? 'تایید شده' : 'در انتظار تایید')
                    ->colors([
                        'success' => true,
                        'warning' => false,
                    ]),

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->dateTime(),

            ])

            ->filters([

                TernaryFilter::make('is_verified')
                    ->label('وضعیت تایید')
                    ->placeholder('همه')
                    ->trueLabel('تایید شده')
                    ->falseLabel('در انتظار تایید'),

            ])

            ->actions([

                Action::make('approve')
                    ->label('تایید')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'is_verified' => true,
                        ]);
                    }),

                Action::make('reject')
                    ->label('رد')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'is_verified' => false,
                        ]);
                    }),

                DeleteAction::make(),

            ])

            ->bulkActions([

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),

            ]);
    }
}
