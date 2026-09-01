<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Auction;
use App\Models\ServiceContract;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\WalletWithdrawal;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/*
| صف کار — چیزهایی که منتظر ما هستند، نه آمار عمومی. هر کارت به همان
| صفحه‌ای می‌رود که کار آنجا انجام می‌شود، و وقتی صفر باشد خاکستری
| می‌ماند تا چشم فقط روی کارهای باقی‌مانده برود.
*/
class ActionQueueWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'صف کار';


    protected function getStats(): array
    {
        return [

            static::queue(
                'کاربران در انتظار تایید',
                User::where('status', 'pending')->count(),
                route('filament.admin.resources.users.index'),
                'heroicon-o-user-plus',
            ),

            static::queue(
                'قرارداد بدون قیمت',
                ServiceContract::where('status', 'pending_review')->count(),
                route('admin.contracts.index', ['status' => 'pending_review']),
                'heroicon-o-document-text',
            ),

            static::queue(
                'برداشت در انتظار',
                WalletWithdrawal::where('status', 'pending')->count(),
                route('admin.withdrawals.index'),
                'heroicon-o-banknotes',
            ),

            // خرابی‌هایی که هنوز به تایید و تسویه نرسیده‌اند
            static::queue(
                'خرابی باز',
                ServiceRequest::whereNotIn('status', ['confirmed', 'cancelled'])->count(),
                route('admin.service.index'),
                'heroicon-o-wrench-screwdriver',
            ),

            static::queue(
                'مزایده در انتظار بررسی',
                Auction::whereIn('status', ['pending_review', 'awaiting_consultation'])->count(),
                route('filament.admin.resources.auctions.index'),
                'heroicon-o-scale',
            ),

        ];
    }


    private static function queue(string $label, int $count, string $url, string $icon): Stat
    {
        return Stat::make($label, number_format($count))
            ->description($count > 0 ? 'رسیدگی کنید' : 'چیزی در صف نیست')
            ->descriptionIcon($icon)
            ->color($count > 0 ? 'warning' : 'gray')
            ->url($url);
    }
}
