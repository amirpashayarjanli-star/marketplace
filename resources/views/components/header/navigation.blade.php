@php
$items = [
    ['title' => 'خانه', 'url' => route('home')],
    ['title' => 'شرکت‌ها', 'url' => '#'],
    ['title' => 'تولیدکنندگان', 'url' => '#'],
    ['title' => 'فروشگاه‌ها', 'url' => '#'],
    ['title' => 'پروژه‌ها', 'url' => '#'],
    ['title' => 'مقالات', 'url' => '#'],
];
@endphp

<nav class="hidden xl:flex items-center gap-2">

    @foreach($items as $item)

        <a href="{{ $item['url'] }}"
           class="rounded-full px-5 py-3 text-[15px] font-semibold text-slate-700 transition-all duration-300 hover:bg-white hover:text-blue-600">

            {{ $item['title'] }}

        </a>

    @endforeach

</nav>