<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Widgets\ActionQueueWidget;
use App\Filament\Admin\Widgets\BusinessOverviewWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->favicon(asset('images/logo/logo-asansor-pro.png'))
            // بدون این‌ها، فیلامنت نام و لوگوی پیش‌فرض خودش/لاراول را
            // در صفحه‌ی ورود و بالای سایدبار نشان می‌دهد.
            ->brandName('آسانسور پرو')
            ->brandLogo(asset('images/logo/logo.png'))
            ->brandLogoHeight('2.5rem')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(
                in: app_path('Filament/Admin/Resources'),
                for: 'App\Filament\Admin\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Admin/Pages'),
                for: 'App\Filament\Admin\Pages'
            )
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Admin/Widgets'),
                for: 'App\Filament\Admin\Widgets'
            )
            ->widgets([
                ActionQueueWidget::class,
                BusinessOverviewWidget::class,
            ])

            /*
            | صفحه‌های گردش‌کاری بیرون از Filament ساخته شده‌اند (خرابی،
            | قرارداد، برداشت، تایید نظرات). بدون این آیتم‌ها تنها راه
            | رسیدن به آن‌ها حفظ کردن آدرسشان بود.
            */
            ->navigationItems([

                NavigationItem::make('خرابی‌ها')
                    ->group('پرو سرویس')
                    ->icon(Heroicon::OutlinedWrenchScrewdriver)
                    ->sort(3)
                    ->url(fn () => route('admin.service.index'))
                    ->isActiveWhen(fn () => request()->routeIs('admin.service.*')),

                NavigationItem::make('قراردادها')
                    ->group('پرو سرویس')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->sort(4)
                    ->url(fn () => route('admin.contracts.index'))
                    ->isActiveWhen(fn () => request()->routeIs('admin.contracts.*')),

                NavigationItem::make('برداشت‌ها')
                    ->group('مالی')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->sort(3)
                    ->url(fn () => route('admin.withdrawals.index'))
                    ->isActiveWhen(fn () => request()->routeIs('admin.withdrawals.*')),

            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
