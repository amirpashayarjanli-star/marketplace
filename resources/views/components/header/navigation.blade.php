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

<nav class="hidden lg:flex items-center">

    <ul class="flex items-center gap-1">

        @foreach($items as $item)

            <li>

                <a href="{{ $item['url'] }}"
                   class="group relative flex h-11 items-center rounded-full px-5 text-[15px] font-semibold text-slate-700 transition duration-300 hover:text-blue-600">

                    {{ $item['title'] }}

                    <span class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-blue-600 transition-all duration-300 group-hover:w-8"></span>

                </a>

            </li>

        @endforeach

    </ul>

</nav>