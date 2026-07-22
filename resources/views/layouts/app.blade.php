<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'آسانسور پرو')</title>

    <meta name="description" content="@yield('description','مرجع صنعت آسانسور ایران')">

    @vite(['resources/css/app.css','resources/js/app.js'])

    @stack('styles')

</head>

<body class="bg-[var(--background)] text-[var(--text)] antialiased">

    @yield('content')

    @stack('scripts')

</body>

</html>