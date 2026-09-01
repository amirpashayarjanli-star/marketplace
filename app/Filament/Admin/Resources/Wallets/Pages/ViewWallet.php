<?php

namespace App\Filament\Admin\Resources\Wallets\Pages;

use App\Filament\Admin\Resources\Wallets\WalletResource;
use Filament\Resources\Pages\ViewRecord;

/*
| کیف‌پول صفحه‌ی ویرایش ندارد، پس بدون این صفحه دفتر تراکنش‌ها هیچ
| جایی برای نمایش نداشت.
*/
class ViewWallet extends ViewRecord
{
    protected static string $resource = WalletResource::class;
}
