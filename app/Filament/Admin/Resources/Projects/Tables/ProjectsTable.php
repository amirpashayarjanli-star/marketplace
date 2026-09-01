<?php

namespace App\Filament\Admin\Resources\Projects\Tables;

use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('type')
                    ->label('نوع کار')
                    ->badge()
                    ->placeholder('—')
                    ->formatStateUsing(fn ($state) => Project::TYPES[$state] ?? $state),

                TextColumn::make('employer.name')
                    ->label('کارفرما')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('city')
                    ->label('شهر')
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Project::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'open'     => 'success',
                        'pending'  => 'warning',
                        'assigned' => 'info',
                        default    => 'gray',
                    }),

                TextColumn::make('inquiries_count')
                    ->label('استعلام')
                    ->counts('inquiries'),

                IconColumn::make('is_active')
                    ->label('در سایت')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('ثبت')
                    ->dateTime('Y/m/d')
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(Project::STATUSES),

                SelectFilter::make('type')
                    ->label('نوع کار')
                    ->options(Project::TYPES),

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
