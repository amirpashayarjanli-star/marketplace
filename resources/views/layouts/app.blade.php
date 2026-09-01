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

    {{--
        فاویکون. گوگل معمولاً /favicon.ico را برمی‌دارد نه لینک صفحه را،
        پس آن فایل هم باید لوگوی ما باشد (قبلاً لوگوی لاراول بود و همان
        در نتایج جست‌وجو دیده می‌شد).
    --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">


    <title>
        @yield('title', 'آسانسور پرو')
    </title>

    <meta name="description"
          content="@yield('description', 'آسانسور پرو، مرجع صنعت آسانسور ایران — شرکت‌های آسانسوری، تولیدکنندگان، فروشگاه‌ها، تکنسین‌ها و پروژه‌های ساختمانی را در یک‌جا پیدا کنید.')">

    {{-- کارت اشتراک‌گذاری در شبکه‌های اجتماعی و تلگرام --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="آسانسور پرو">
    <meta property="og:title" content="@yield('title', 'آسانسور پرو')">
    <meta property="og:description"
          content="@yield('description', 'مرجع صنعت آسانسور ایران — شرکت‌ها، تولیدکنندگان، فروشگاه‌ها، تکنسین‌ها و پروژه‌ها در یک‌جا.')">
    <meta property="og:image" content="{{ asset('favicon-512x512.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary">


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


</head>


<body>





    <main>

        @yield('content')

    </main>


</body>

</html>
