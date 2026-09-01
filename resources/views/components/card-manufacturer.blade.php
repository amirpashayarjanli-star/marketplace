<div class="company-card manufacturer-card">


    <div class="company-logo">

        <img
            src="{{ $manufacturer->logo ? asset($manufacturer->logo) : asset('images/default-logo.png') }}"
            alt="{{ $manufacturer->name }}">

    </div>


    <h3>
        {{ $manufacturer->name }}
    </h3>


    <div class="manufacturer-type">

        <x-ui.icon name="industry" />

        تولیدکننده تجهیزات آسانسور

    </div>


    <div class="company-info">


        <span>

            <x-ui.icon name="location-dot" />

            {{ $manufacturer->city }}

        </span>


        <span>

            <x-ui.icon name="star" />

            {{ $manufacturer->rating ?? 0 }}

        </span>


    </div>



    <div class="manufacturer-products">

        <span>
            موتور آسانسور
        </span>

        <span>
            تابلو فرمان
        </span>

        <span>
            قطعات
        </span>

    </div>



    <div class="company-comments">

        <x-ui.icon name="comments" />

        {{ $manufacturer->reviews_count ?? 0 }} نظر

    </div>



    <a href="{{ route('manufacturer.profile', $manufacturer->slug) }}"
       class="company-profile-btn">


        مشاهده پروفایل


        <x-ui.icon name="arrow-left" />


    </a>


</div>
