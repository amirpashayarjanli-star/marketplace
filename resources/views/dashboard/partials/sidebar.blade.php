@php
    $user = auth()->user();
    $wizard = \App\Services\ProfileWizard::for($user);
    $isApproved = $user->status === 'approved';
@endphp


{{-- پرده‌ی پشت منو — فقط موبایل --}}
<div class="dashboard-nav-backdrop"
     x-show="nav"
     x-transition.opacity
     x-on:click="nav = false"
     x-cloak></div>


<aside class="dashboard-sidebar" :class="nav && 'is-open'">


    <a href="{{ route('home') }}" class="dashboard-brand">
        <span class="brand-blue">آسانسور</span>
        <span class="brand-yellow">پرو</span>
    </a>


    {{-- وضعیت پروفایل --}}

    @unless($isApproved)

        <a href="{{ route('profile.wizard') }}" class="dashboard-progress">

            <div class="dashboard-progress-head">
                <span>تکمیل پروفایل</span>
                <strong>{{ $wizard->percentComplete() }}٪</strong>
            </div>

            <div class="dashboard-progress-track">
                <div class="dashboard-progress-bar" style="width: {{ $wizard->percentComplete() }}%"></div>
            </div>

            <p class="dashboard-progress-note">
                @if($user->status === 'pending')
                    در انتظار تایید مدیر
                @elseif($user->status === 'rejected')
                    تایید نشد
                @else
                    تا تایید نشوید در سایت دیده نمی‌شوید
                @endif
            </p>

        </a>

    @endunless


    <nav class="dashboard-nav">

        <a href="{{ route('dashboard') }}"
           @class(['dashboard-nav-link', 'is-disabled' => ! $isApproved])>
            <span aria-hidden="true">🏠</span> داشبورد
        </a>

        <a href="{{ route('profile.wizard') }}" class="dashboard-nav-link">
            <span aria-hidden="true">👤</span> پروفایل
        </a>


        @if($isApproved)

            @if($user->type == 'company')

                <a href="{{ route('dashboard.projects') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">📁</span> پروژه‌های من
                </a>

                <a href="{{ route('dashboard.bids') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">🔨</span> پیشنهادهای مزایده
                </a>

                <a href="{{ route('wallet') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">💰</span> کیف پول
                </a>

            @elseif($user->type == 'employer')

                <a href="{{ route('dashboard.projects.create') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">➕</span> ثبت پروژه جدید
                </a>

                <a href="{{ route('dashboard.projects') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">📁</span> پروژه‌های من
                </a>

                <a href="{{ route('dashboard.auctions') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">🔨</span> مزایده‌های من
                </a>

                <a href="{{ route('dashboard.auctions.create') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">➕</span> مزایده جدید
                </a>

            @elseif($user->type == 'technician')

                <a href="{{ route('service.jobs') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">🛠️</span> کارهای پروسرویس
                </a>

                <a href="{{ route('dashboard.bids') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">🔨</span> پیشنهادهای مزایده
                </a>

                <a href="{{ route('wallet') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">💰</span> کیف پول
                </a>

            @elseif($user->type == 'customer')

                <a href="{{ route('service.buildings') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">🏢</span> پرونده‌های من
                </a>

                <a href="{{ route('service.index') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">🛠️</span> خرابی‌های من
                </a>

                <a href="{{ route('wallet') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">💰</span> کیف پول
                </a>

            @elseif($user->type == 'manufacturer')

                <a href="{{ route('dashboard.bids') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">🔨</span> پیشنهادهای مزایده
                </a>

                <a href="{{ route('wallet') }}" class="dashboard-nav-link">
                    <span aria-hidden="true">💰</span> کیف پول
                </a>

            @endif

        @endif


        <hr class="dashboard-nav-sep">


        <a href="{{ route('home') }}" class="dashboard-nav-link">
            <span aria-hidden="true">↩️</span> بازگشت به سایت
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dashboard-nav-link dashboard-nav-logout">
                <span aria-hidden="true">🚪</span> خروج
            </button>
        </form>


    </nav>

</aside>
