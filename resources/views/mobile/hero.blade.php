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

    <x-hero-dollar :dollar="$dollar" />




    {{-- تراست بار --}}

    @include('mobile.trust-bar')



</section>
