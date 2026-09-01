<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    {{-- قبل از لود شدن CSS اجرا میشه تا صفحه یه لحظه با تم اشتباه چشمک نزنه --}}
    <script>
        (function () {
            var saved = localStorage.getItem('theme');
            var theme = saved === 'dark' || saved === 'light'
                ? saved
                : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <title>@yield('title', 'آسانسور پرو | داشبورد')</title>

    <meta name="robots" content="noindex, nofollow">

    {{--
    | داشبورد قبلاً از cdn.tailwindcss.com تغذیه می‌شد، برای همین نه سیستم
    | طراحی سایت رو داشت، نه فونت، نه حالت شب — و آن CDN اصلاً برای
    | production ساخته نشده. حالا از همان باندل اصلی سایت تغذیه می‌شود.
    --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


<div class="dashboard-shell" x-data="{ nav: false }">


    @include('dashboard.partials.sidebar')


    <div class="dashboard-main">

        @include('dashboard.partials.header')

        <main class="dashboard-content">

            @yield('content')

        </main>

    </div>


</div>


</body>

</html>
