<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Models\User;
use App\Services\ProfileWizard;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('name')
                    ->label('نام')
                    ->placeholder('— (پروفایل ناقص)')
                    ->searchable(),

                TextColumn::make('mobile')
                    ->label('موبایل')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('type')
                    ->label('نوع حساب')
                    ->badge()
                    ->placeholder('—')
                    ->formatStateUsing(fn ($state) => User::TYPES[$state] ?? $state),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn ($state) => User::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'approved'   => 'success',
                        'pending'    => 'warning',
                        'rejected'   => 'danger',
                        'incomplete' => 'gray',
                        default      => 'gray',
                    }),

                TextColumn::make('role')
                    ->label('نقش')
                    ->badge()
                    ->formatStateUsing(fn ($state) => User::ROLES[$state] ?? $state)
                    ->color(fn ($state) => $state === 'admin' ? 'primary' : 'gray'),

                TextColumn::make('created_at')
                    ->label('ثبت‌نام')
                    ->dateTime('Y/m/d')
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(User::STATUSES),

                SelectFilter::make('type')
                    ->label('نوع حساب')
                    ->options(User::TYPES),

                SelectFilter::make('role')
                    ->label('نقش')
                    ->options(User::ROLES),

            ])

            ->recordActions([

                /*
                | همان منطق صفحه‌ی دست‌ساز «تایید کاربران» که این ریسورس
                | جایش را گرفت: پروفایل باید وجود داشته باشد و کامل باشد،
                | وگرنه تایید یعنی گذاشتن یک پروفایل نصفه در دایرکتوری.
                */
                Action::make('approve')
                    ->label('تایید')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (User $record) => $record->status !== 'approved')
                    ->requiresConfirmation()
                    ->action(function (User $record) {

                        $wizard  = ProfileWizard::for($record);
                        $profile = $wizard->profile();

                        if (! $profile) {
                            Notification::make()
                                ->title('این کاربر هنوز پروفایلی نساخته است.')
                                ->danger()
                                ->send();

                            return;
                        }

                        if (! $wizard->isComplete()) {
                            Notification::make()
                                ->title('پروفایل این کاربر کامل نیست و قابل تایید نیست.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $record->update(['status' => 'approved']);

                        $profile->update([
                            'is_active'   => true,
                            'is_verified' => true,
                        ]);

                        Notification::make()
                            ->title('کاربر تایید شد و پروفایلش در سایت نمایش داده می‌شود.')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('رد / مسدود کردن')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (User $record) => $record->status !== 'rejected' && $record->role !== 'admin')
                    ->requiresConfirmation()
                    ->modalDescription('حساب بسته می‌شود و پروفایلش از سایت برداشته می‌شود.')
                    ->action(function (User $record) {

                        $record->update(['status' => 'rejected']);

                        ProfileWizard::for($record)->profile()?->update([
                            'is_active'   => false,
                            'is_verified' => false,
                        ]);

                        Notification::make()
                            ->title('کاربر رد شد و پروفایلش در سایت نمایش داده نمی‌شود.')
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
