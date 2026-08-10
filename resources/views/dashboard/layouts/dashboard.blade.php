<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
آسانسور پرو | داشبورد
</title>


<script src="https://cdn.tailwindcss.com"></script>


</head>


<body class="bg-gray-100">


<div class="min-h-screen flex">


    @include('dashboard.partials.sidebar')


    <div class="flex-1">


        @include('dashboard.partials.header')


        <main class="p-6">

            @yield('content')

        </main>


    </div>


</div>


</body>

</html>
