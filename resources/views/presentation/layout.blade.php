<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'ارائه: مدل‌های لایه‌ای شبکه')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-asansor-pro.png') }}">

    {{--
    | صفحه عمداً به build ویت و CSS سایت وابسته نیست: اسلاید باید با
    | هر مرورگری روی کامپیوتر مدرسه، حتی اگر استایل سایت عوض شود، همان
    | شکلی بماند که تمرین شده. فقط فونت وزیرمتن را از build می‌گیرد.
    --}}
    <style>
        @if ($fontUrl)
        @font-face {
            font-family: 'Vazirmatn';
            src: url('{{ $fontUrl }}') format('woff2');
            font-weight: 100 900;
            font-style: normal;
            font-display: swap;
        }
        @endif

        :root {
            --ink: #0f172a;
            --ink-soft: #475569;
            --ink-faint: #94a3b8;
            --paper: #f8fafc;
            --card: #ffffff;
            --line: #e2e8f0;
            --brand: #2563eb;
            --brand-soft: #dbeafe;

            --l7: #db2777;
            --l6: #9333ea;
            --l5: #4f46e5;
            --l4: #0284c7;
            --l3: #059669;
            --l2: #ca8a04;
            --l1: #ea580c;

            --font: 'Vazirmatn', 'Segoe UI', Tahoma, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            height: 100%;
            background: var(--paper);
            color: var(--ink);
            font-family: var(--font);
            -webkit-font-smoothing: antialiased;
        }

        button, input { font-family: inherit; }

        .ltr { direction: ltr; unicode-bidi: isolate; }

        @yield('styles')
    </style>
</head>
<body>
    @yield('content')

    @yield('scripts')
</body>
</html>
