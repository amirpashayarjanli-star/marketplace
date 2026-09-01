<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Auction;
use App\Models\Building;
use App\Models\ServiceContract;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletPayment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/*
| وضعیت کسب‌وکار — اعدادی که کاری نمی‌خواهند ولی باید هر روز دیده شوند.
*/
class BusinessOverviewWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'وضعیت کلی';


    protected function getStats(): array
    {
        $activeContracts = ServiceContract::where('status', 'active')
            ->whereDate('ends_at', '>=', now()->toDateString())
            ->count();

        $buildings = Building::count();

        $approvedUsers = User::where('status', 'approved')->count();

        $activeAuctions = Auction::where('status', 'active')->count();

        // مجموع موجودی کیف‌پول‌ها؛ این پولِ ماست که دست کاربران امانت است.
        $walletFloat = (int) Wallet::sum('balance');

        // شارژهای موفق این ماه
        $paidThisMonth = (int) WalletPayment::where('status', 'paid')
            ->where('paid_at', '>=', now()->startOfMonth())
            ->sum('amount');

        return [

            Stat::make('کاربران تاییدشده', number_format($approvedUsers))
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->url(route('filament.admin.resources.users.index')),

            Stat::make('پرونده‌ی ساختمان', number_format($buildings))
                ->description($activeContracts . ' قرارداد فعال')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('success')
                ->url(route('filament.admin.resources.buildings.index')),

            Stat::make('مزایده‌ی فعال', number_format($activeAuctions))
                ->descriptionIcon('heroicon-o-scale')
                ->color('info')
                ->url(route('filament.admin.resources.auctions.index')),

            Stat::make('موجودی کیف‌پول‌ها', number_format($walletFloat) . ' تومان')
                ->description('امانت نزد ما')
                ->descriptionIcon('heroicon-o-wallet')
                ->color('gray')
                ->url(route('filament.admin.resources.wallets.index')),

            Stat::make('شارژ این ماه', number_format($paidThisMonth) . ' تومان')
                ->description('پرداخت‌های موفق زرین‌پال')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('success')
                ->url(route('filament.admin.resources.wallet-payments.index')),

        ];
    }
}
