<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>
        @yield('title', 'آسانسور پرو')
    </title>


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
