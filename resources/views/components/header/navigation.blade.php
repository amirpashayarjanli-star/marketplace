@php
$items = [
    ['title' => 'خانه', 'url' => route('home')],
    ['title' => 'شرکت‌ها', 'url' => route('companies.index')],
    ['title' => 'تولیدکنندگان', 'url' => route('manufacturers.index')],
    ['title' => 'فروشگاه‌ها', 'url' => route('stores.index')],
    ['title' => 'پروژه‌ها', 'url' => route('projects.index')],
    ['title' => 'مقالات', 'url' => route('home') . '#articles'],
];
@endphp

<nav class="hidden lg:flex items-center">

    <ul class="flex items-center gap-1">

        @foreach($items as $item)

            <li>

                <a href="{{ $item['url'] }}"
                   class="group relative flex h-11 items-center rounded-full px-3.5 text-[15px] font-semibold text-slate-700 transition duration-300 hover:text-blue-600">

                    {{ $item['title'] }}

                    <span class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-blue-600 transition-all duration-300 group-hover:w-8"></span>

                </a>

            </li>

        @endforeach


        <li>

            <a href="{{ route('auctions.index') }}"
               class="pro-service-btn pro-auction-btn">

                <span class="pro-service-pro">پرو</span><span class="pro-auction-word">مزایده</span>

            </a>

        </li>


        <li>

            <a href="{{ route('service.index') }}"
               class="pro-service-btn">

                <span class="pro-service-pro">پرو</span><span class="pro-service-service">سرویس</span>

            </a>

        </li>


    </ul>

</nav>
