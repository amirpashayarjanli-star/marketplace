<?php

namespace App\Filament\Admin\Resources\Buildings\Tables;

use App\Models\Building;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BuildingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('code')
                    ->label('شماره پرونده')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('title')
                    ->label('ساختمان')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('customer.name')
                    ->label('مشتری')
                    ->searchable(),

                TextColumn::make('customer.mobile')
                    ->label('موبایل')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('city')
                    ->label('شهر')
                    ->placeholder('—'),

                TextColumn::make('elevators_count')
                    ->label('دستگاه')
                    ->counts('elevators'),

                TextColumn::make('contract_state')
                    ->label('قرارداد')
                    ->badge()
                    ->state(fn (Building $record) => $record->activeContract
                        ? $record->activeContract->termLabel()
                        : 'بدون قرارداد')
                    ->color(fn (Building $record) => $record->activeContract ? 'success' : 'gray'),

                TextColumn::make('service_requests_count')
                    ->label('خرابی')
                    ->counts('serviceRequests')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('ثبت')
                    ->dateTime('Y/m/d')
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('province')
                    ->label('استان')
                    ->options(fn () => Building::query()
                        ->whereNotNull('province')
                        ->distinct()
                        ->pluck('province', 'province')
                        ->all()),

                Filter::make('without_contract')
                    ->label('بدون قرارداد فعال')
                    ->query(fn (Builder $query) => $query->whereDoesntHave(
                        'contracts',
                        fn (Builder $q) => $q->where('status', 'active')
                            ->whereDate('ends_at', '>=', now()->toDateString()),
                    )),

            ])

            ->recordActions([

                Action::make('file')
                    ->label('پرونده')
                    ->icon(Heroicon::OutlinedFolderOpen)
                    ->color('primary')
                    ->url(fn (Building $record) => route('admin.buildings.show', $record)),

                EditAction::make(),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
