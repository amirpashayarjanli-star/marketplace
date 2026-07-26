<div class="company-card">


    <div class="company-logo">

        <img
            src="{{ $company->logo ? asset($company->logo) : asset('images/default-logo.png') }}"
            alt="{{ $company->name }}">

    </div>


    <h3>
        {{ $company->name }}
    </h3>


    <div class="company-info">


        <span>

            <i class="fa-solid fa-location-dot"></i>

            {{ $company->city }}

        </span>


        <span>

            <i class="fa-solid fa-star"></i>

            {{ $company->rating ?? 0 }}

        </span>


    </div>


    <div class="company-comments">

        <i class="fa-solid fa-comments"></i>

        {{ $company->reviews_count ?? 0 }} نظر

    </div>



    <a href="{{ route('company.profile', $company->slug) }}"
       class="company-profile-btn">


        مشاهده پروفایل


        <i class="fa-solid fa-arrow-left"></i>


    </a>


</div>
