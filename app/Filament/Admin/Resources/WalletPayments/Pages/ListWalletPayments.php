<?php

namespace App\Filament\Admin\Resources\WalletPayments\Pages;

use App\Filament\Admin\Resources\WalletPayments\WalletPaymentResource;
use Filament\Resources\Pages\ListRecords;

class ListWalletPayments extends ListRecords
{
    protected static string $resource = WalletPaymentResource::class;
}
