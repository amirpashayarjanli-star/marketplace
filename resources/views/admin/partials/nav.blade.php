{{--
| ناوبری بین صفحه‌های مدیریتِ دست‌ساز.
| پنل Filament جای خودش است؛ این‌ها صفحه‌هایی‌اند که خارج از آن ساخته شده‌اند
| و بدون این نوار هیچ راهی برای رسیدن به آن‌ها نبود.
--}}

<nav class="admin-nav">

    <a href="{{ route('admin.users') }}"
       @class(['auction-tab', 'is-active' => request()->routeIs('admin.users')])>
        تایید کاربران
    </a>

    <a href="{{ route('admin.reviews') }}"
       @class(['auction-tab', 'is-active' => request()->routeIs('admin.reviews*')])>
        تایید نظرات
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
