<section class="mobile-hero-card">


    {{-- Header روی هیرو --}}

    <div class="mobile-header-overlay">

        @include('mobile.header')

    </div>




    {{-- تصویر هیرو --}}

    <div class="mobile-hero-image">

        <img
        src="{{ asset('images/hero/mobile-hero.webp') }}"
        alt="آسانسور پرو">

    </div>





    {{-- متن هیرو --}}

    <div class="mobile-hero-content">


        <span class="mobile-hero-badge">

            آسانسور پرو

        </span>




        <h1>

            شروع هر پروژه از


            <br>


            <span class="text-blue-700">

                آسانسور

            </span>


            <span class="text-yellow-500">

                پرو

            </span>


        </h1>


    </div>





    {{-- دلار --}}

    {{-- نسخه‌ی موبایل در فاز بعد بازطراحی میشه؛ فعلاً از همون
         نرخ دلارِ سرویس جدید تغذیه می‌کنه تا نشکنه. --}}
    <x-hero-dollar :dollar="[
        'price'  => \App\Services\MarketRatesService::toToman($marketRates['usd']['value'] ?? null) ?? 0,
        'change' => \App\Services\MarketRatesService::toToman($marketRates['usd']['change'] ?? null) ?? 0,
    ]" />




    {{-- تراست بار --}}

    @include('mobile.trust-bar')



</section>
