<?php

namespace App\Filament\Admin\Resources\WalletPayments;

use App\Filament\Admin\Resources\WalletPayments\Pages\ListWalletPayments;
use App\Filament\Admin\Resources\WalletPayments\Tables\WalletPaymentsTable;
use App\Models\WalletPayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

/**
 * شارژهای کیف‌پول از درگاه. فقط خواندنی — سند پرداخت است.
 */
class WalletPaymentResource extends Resource
{
    protected static ?string $model = WalletPayment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static string|UnitEnum|null $navigationGroup = 'مالی';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'شارژهای درگاه';
    protected static ?string $modelLabel = 'پرداخت';
    protected static ?string $pluralModelLabel = 'پرداخت‌ها';


    public static function table(Table $table): Table
    {
        return WalletPaymentsTable::configure($table);
    }


    public static function canCreate(): bool
    {
        return false;
    }


    public static function getPages(): array
    {
        return [
            'index' => ListWalletPayments::route('/'),
        ];
    }
}
