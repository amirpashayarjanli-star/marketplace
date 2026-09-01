<?php

namespace App\Filament\Admin\Resources\ProjectInquiries\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectInquiriesTable
{
    private const STATUSES = [
        'pending'  => 'در انتظار پاسخ',
        'assigned' => 'واگذار شده',
        'accepted' => 'پذیرفته شده',
        'rejected' => 'رد شده',
    ];


    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),

                TextColumn::make('project.title')
                    ->label('پروژه')
                    ->limit(35)
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('فرستنده')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('type')
                    ->label('نوع')
                    ->badge()
                    ->placeholder('—'),

                TextColumn::make('message')
                    ->label('پیام')
                    ->limit(70)
                    ->wrap(),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn ($state) => self::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'accepted' => 'success',
                        'pending'  => 'warning',
                        'assigned' => 'info',
                        'rejected' => 'danger',
                        default    => 'gray',
                    }),

            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(self::STATUSES),

            ]);
    }
}
