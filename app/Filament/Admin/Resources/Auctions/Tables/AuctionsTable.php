<?php

namespace App\Filament\Admin\Resources\Auctions\Tables;

use App\Models\Auction;
use App\Services\AuctionService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AuctionsTable
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

                TextColumn::make('source')
                    ->label('منبع')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Auction::SOURCES[$state] ?? $state)
                    ->color(fn ($state) => $state === 'external' ? 'info' : 'gray'),

                TextColumn::make('employer.name')
                    ->label('کارفرما')
                    ->placeholder('— (ستاد)')
                    ->searchable(),

                TextColumn::make('scope')
                    ->label('نوع کار')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Auction::SCOPES[$state] ?? $state),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Auction::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'active'                => 'success',
                        'pending_review'        => 'warning',
                        'awaiting_consultation' => 'warning',
                        'closed'                => 'info',
                        'awarded'               => 'primary',
                        'cancelled'             => 'danger',
                        default                 => 'gray',
                    }),

                TextColumn::make('consultation_state')
                    ->label('مشاوره')
                    ->badge()
                    ->state(fn (Auction $record) => match (true) {
                        $record->isExternal()             => '—',
                        $record->consulted_at === null && $record->callback_requested_at !== null => 'درخواست تماس',
                        $record->consulted_at === null    => 'انجام‌نشده',
                        $record->consultationFeeDue()     => 'مشاوره شد / پرداخت‌نشده',
                        (int) $record->consultation_fee > 0 => 'پرداخت‌شده',
                        default                           => 'انجام شد',
                    })
                    ->color(fn ($state) => match ($state) {
                        'انجام شد', 'پرداخت‌شده' => 'success',
                        'درخواست تماس'          => 'info',
                        'مشاوره شد / پرداخت‌نشده' => 'warning',
                        'انجام‌نشده'            => 'danger',
                        default                => 'gray',
                    }),

                TextColumn::make('bids_count')
                    ->label('پیشنهادها')
                    ->counts('bids'),

                TextColumn::make('ends_at')
                    ->label('پایان مهلت')
                    ->dateTime('Y/m/d H:i')
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('ثبت')
                    ->dateTime('Y/m/d')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([

                SelectFilter::make('source')
                    ->label('منبع')
                    ->options(Auction::SOURCES),

                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(Auction::STATUSES),

                SelectFilter::make('scope')
                    ->label('نوع کار')
                    ->options(Auction::SCOPES),

            ])

            ->recordActions([

                Action::make('consult')
                    ->label('ثبت مشاوره')
                    ->icon(Heroicon::OutlinedPhone)
                    ->color('warning')
                    ->visible(fn (Auction $record) => $record->status === 'awaiting_consultation')
                    ->schema([
                        Textarea::make('note')
                            ->label('یادداشت مشاوره')
                            ->rows(3)
                            ->helperText('خلاصه‌ی تماس و توافق‌ها.'),
                    ])
                    ->action(function (Auction $record, array $data) {

                        app(AuctionService::class)->recordConsultation(
                            $record,
                            auth()->user(),
                            $data['note'] ?? null,
                        );

                        Notification::make()
                            ->title('مشاوره ثبت شد. مزایده در انتظار تایید نهایی است.')
                            ->success()
                            ->send();
                    }),

                Action::make('approve')
                    ->label('تایید و انتشار')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (Auction $record) => in_array($record->status, ['pending_review', 'draft'], true)
                        && $record->readyToPublish())
                    ->requiresConfirmation()
                    ->action(function (Auction $record) {

                        app(AuctionService::class)->publish($record);

                        Notification::make()
                            ->title('مزایده منتشر شد — پیامک اطلاع‌رسانی طی چند دقیقه ارسال می‌شود')
                            ->success()
                            ->send();
                    }),

                Action::make('awaiting_fee')
                    ->label('منتظر پرداخت هزینه‌ی مشاوره')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->color('gray')
                    ->disabled()
                    ->visible(fn (Auction $record) => in_array($record->status, ['pending_review', 'draft'], true)
                        && $record->consultationFeeDue()),

                Action::make('close')
                    ->label('بستن مهلت')
                    ->icon(Heroicon::OutlinedLockClosed)
                    ->color('info')
                    ->visible(fn (Auction $record) => $record->status === 'active')
                    ->requiresConfirmation()
                    ->action(function (Auction $record) {
                        $record->update(['status' => 'closed', 'ends_at' => now()]);

                        Notification::make()
                            ->title('مهلت مزایده بسته شد')
                            ->success()
                            ->send();
                    }),

                Action::make('cancel')
                    ->label('لغو و برگشت کارمزد')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (Auction $record) => ! in_array($record->status, ['awarded', 'cancelled'], true))
                    ->requiresConfirmation()
                    ->schema([
                        Textarea::make('reason')->label('دلیل (اختیاری)')->rows(2),
                    ])
                    ->action(function (Auction $record, array $data) {
                        app(AuctionService::class)->cancel($record, $data['reason'] ?? null);

                        Notification::make()
                            ->title('مزایده لغو شد و کارمزدها برگشت داده شد')
                            ->success()
                            ->send();
                    }),

                EditAction::make(),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
