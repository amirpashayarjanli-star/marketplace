<?php

namespace App\Filament\Admin\Resources\Auctions\RelationManagers;

use App\Services\AuctionService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BidsRelationManager extends RelationManager
{
    protected static string $relationship = 'bids';

    protected static ?string $title = 'پیشنهادها';


    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->defaultSort('amount', 'asc')

            ->columns([

                TextColumn::make('user.name')
                    ->label('پیشنهاددهنده')
                    ->searchable(),

                TextColumn::make('user.type')
                    ->label('نقش')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'company'      => 'شرکت',
                        'manufacturer' => 'تولیدکننده',
                        'technician'   => 'تکنسین',
                        default        => $state,
                    }),

                TextColumn::make('amount')
                    ->label('مبلغ (تومان)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('delivery_days')
                    ->label('زمان تحویل (روز)')
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'active'    => 'فعال',
                        'won'       => 'برنده',
                        'lost'      => 'بازنده',
                        'withdrawn' => 'انصراف',
                        default     => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'won'    => 'success',
                        'active' => 'info',
                        'lost'   => 'gray',
                        default  => 'danger',
                    }),

                TextColumn::make('created_at')
                    ->label('ثبت')
                    ->dateTime('Y/m/d H:i'),

            ])

            ->recordActions([

                Action::make('award')
                    ->label('اعلام برنده')
                    ->icon(Heroicon::OutlinedTrophy)
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'active'
                        && in_array($record->auction->status, ['active', 'closed'], true))
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        app(AuctionService::class)->award($record->auction, $record);

                        Notification::make()
                            ->title('برنده‌ی مزایده اعلام شد')
                            ->success()
                            ->send();
                    }),

            ])

            ->toolbarActions([]);
    }
}
