<div class="company-card store-card">


    <div class="company-logo">

        <img
            src="{{ $store->logo ? asset($store->logo) : asset('images/default-logo.png') }}"
            alt="{{ $store->name }}">

    </div>


    <h3>
        {{ $store->name }}
    </h3>


    <div class="store-type">

        <x-ui.icon name="store" />

        فروشگاه قطعات آسانسور

    </div>


    <div class="company-info">


        <span>

            <x-ui.icon name="location-dot" />

            {{ $store->city }}

        </span>


        <span>

            <x-ui.icon name="star" />

            {{ $store->rating ?? 0 }}

        </span>


    </div>



    <div class="store-products">

        <span>
            موتور
        </span>

        <span>
            تابلو فرمان
        </span>

        <span>
            درب آسانسور
        </span>

    </div>



    <div class="company-comments">

        <x-ui.icon name="comments" />

        {{ $store->reviews_count ?? 0 }} نظر

    </div>



    <a href="{{ route('store.profile', $store->slug) }}"
       class="company-profile-btn">


        مشاهده فروشگاه


        <x-ui.icon name="arrow-left" />


    </a>


</div>
