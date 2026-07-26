<div class="company-card store-card">


    <div class="company-logo">


        <img
            src="{{ asset($store['logo']) }}"
            alt="{{ $store['name'] }}">


    </div>




    <h3>

        {{ $store['name'] }}

    </h3>




    <div class="store-type">


        <i class="fa-solid fa-store"></i>


        فروشگاه قطعات آسانسور


    </div>




    <div class="company-info">


        <span>

            <i class="fa-solid fa-location-dot"></i>

            {{ $store['city'] }}

        </span>



        <span>

            <i class="fa-solid fa-star"></i>

            {{ $store['rating'] }}

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


        <i class="fa-solid fa-comments"></i>


        {{ $store['comments'] ?? $store['reviews_count'] ?? 0 }} نظر


    </div>




    <a href="{{ route('store.profile', $store['slug']) }}"
       class="company-profile-btn">


        مشاهده فروشگاه


        <i class="fa-solid fa-arrow-left"></i>


    </a>



</div>
