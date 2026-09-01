@php
$items = [
    ['title' => 'خانه', 'url' => route('home')],
    ['title' => 'شرکت‌ها', 'url' => route('companies.index')],
    ['title' => 'تولیدکنندگان', 'url' => route('manufacturers.index')],
    ['title' => 'فروشگاه‌ها', 'url' => route('stores.index')],
    ['title' => 'تکنسین‌ها', 'url' => route('technicians.index')],
    ['title' => 'پروژه‌ها', 'url' => route('projects.index')],
    ['title' => 'مقالات', 'url' => route('home') . '#articles'],
];
@endphp

{{--
    منوی موبایل. قبلاً فقط یک دکمه‌ی همبرگر بی‌کار بود و روی موبایل
    هیچ راهی برای رسیدن به بخش‌های سایت وجود نداشت.
--}}

<div x-data="{ open: false }" class="lg:hidden">

    <button
        type="button"
        class="mobile-menu-btn"
        aria-label="منو"
        :aria-expanded="open"
        @click="open = true">

        <x-ui.icon name="bars" />

    </button>


    {{--
        کشو با x-teleport به body منتقل می‌شود. هدر روی .glass-premium
        از backdrop-filter استفاده می‌کند و آن برای فرزندانِ position:fixed
        یک containing block می‌سازد — بدون teleport، کشو نسبت به کادر هدر
        جای می‌گرفت نه کل صفحه.

        حالتِ باز هم با :style درون‌خطی ست می‌شود نه x-transition؛
        نسخه‌ی کلاس‌محورِ x-transition کشو را با display:none گیر می‌انداخت.
        انیمیشن را همان transition تعریف‌شده در CSS انجام می‌دهد.
    --}}

    <template x-teleport="body">

    <div>

    {{-- پرده --}}
    <div
        class="mobile-drawer-backdrop"
        :style="open ? 'opacity:1; visibility:visible;' : ''"
        @click="open = false"></div>


    {{-- کشو --}}
    <aside
        class="mobile-drawer"
        :style="open ? 'transform:translateX(0); visibility:visible;' : ''"
        @keydown.escape.window="open = false">

        <div class="mobile-drawer-head">

            <span class="mobile-drawer-title">
                <span class="pro-service-pro">آسانسور</span><span class="pro-auction-word">پرو</span>
            </span>

            <button type="button" class="mobile-menu-btn" aria-label="بستن" @click="open = false">
                <x-ui.icon name="close" />
            </button>

        </div>


        <nav class="mobile-drawer-nav">

            @foreach($items as $item)
                <a href="{{ $item['url'] }}" class="mobile-drawer-link">
                    {{ $item['title'] }}
                </a>
            @endforeach

        </nav>


        <div class="mobile-drawer-actions">

            <a href="{{ route('auctions.index') }}" class="pro-service-btn pro-auction-btn">
                <span class="pro-service-pro">پرو</span><span class="pro-auction-word">مزایده</span>
            </a>

            <a href="{{ route('service.index') }}" class="pro-service-btn">
                <span class="pro-service-pro">پرو</span><span class="pro-service-service">سرویس</span>
            </a>

        </div>


        <div class="mobile-drawer-foot">

            @auth
                <a href="{{ auth()->user()->type === 'customer' ? route('service.index') : route('dashboard') }}"
                   class="mobile-drawer-link">داشبورد من</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-drawer-link mobile-drawer-logout">خروج</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-drawer-link">ورود</a>
                <a href="{{ route('register') }}" class="mobile-drawer-link">ثبت‌نام رایگان</a>
            @endauth

        </div>

    </aside>

    </div>

    </template>

</div>
