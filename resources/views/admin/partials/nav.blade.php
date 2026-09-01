{{--
| ناوبری صفحه‌های مدیریتِ دست‌ساز.
|
| این‌ها صفحه‌های گردش‌کاری‌اند که بیرون از Filament ساخته شده‌اند. سایدبار
| پنل هم به همین‌ها لینک می‌دهد؛ این نوار برای وقتی است که کاربر داخل خودِ
| این صفحه‌هاست و سایدبار Filament را ندارد. دو لینک اول راه برگشت به پنل‌اند.
--}}

<nav class="admin-nav">

    <a href="{{ route('filament.admin.pages.dashboard') }}" class="auction-tab">
        داشبورد
    </a>

    <a href="{{ route('filament.admin.resources.buildings.index') }}" class="auction-tab">
        پرونده‌ها
    </a>

    <a href="{{ route('admin.buildings.create') }}"
       @class(['auction-tab', 'is-active' => request()->routeIs('admin.buildings.*')])>
        پرونده‌ی جدید
    </a>

    <a href="{{ route('admin.service.index') }}"
       @class(['auction-tab', 'is-active' => request()->routeIs('admin.service.*')])>
        خرابی‌ها
    </a>

    <a href="{{ route('admin.contracts.index') }}"
       @class(['auction-tab', 'is-active' => request()->routeIs('admin.contracts.*')])>
        قراردادها
    </a>

    <a href="{{ route('admin.withdrawals.index') }}"
       @class(['auction-tab', 'is-active' => request()->routeIs('admin.withdrawals.*')])>
        برداشت‌ها
    </a>

</nav>
