<?php

namespace App\Filament\Admin\Resources\Wallets;

use App\Filament\Admin\Resources\Wallets\Pages\ListWallets;
use App\Filament\Admin\Resources\Wallets\Pages\ViewWallet;
use App\Filament\Admin\Resources\Wallets\RelationManagers\TransactionsRelationManager;
use App\Filament\Admin\Resources\Wallets\Tables\WalletsTable;
use App\Models\Wallet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

/*
| کیف‌پول‌ها فقط خواندنی‌اند. موجودی تنها از راه credit/debit مدل Wallet
| عوض می‌شود تا هر تغییری تراکنش خودش را داشته باشد؛ ویرایش دستی عدد
| موجودی، دفتر را با تراکنش‌ها ناهماهنگ می‌کند.
*/
class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWallet;

    protected static string|UnitEnum|null $navigationGroup = 'مالی';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'کیف‌پول‌ها';
    protected static ?string $modelLabel = 'کیف‌پول';
    protected static ?string $pluralModelLabel = 'کیف‌پول‌ها';


    public static function table(Table $table): Table
    {
        return WalletsTable::configure($table);
    }


    public static function getRelations(): array
    {
        return [
            TransactionsRelationManager::class,
        ];
    }


    public static function canCreate(): bool
    {
        return false;
    }


    public static function getPages(): array
    {
        return [
            'index' => ListWallets::route('/'),
            'view'  => ViewWallet::route('/{record}'),
        ];
    }
}
