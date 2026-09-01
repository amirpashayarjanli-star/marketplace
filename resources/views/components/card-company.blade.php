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

            <x-ui.icon name="location-dot" />

            {{ $company->city }}

        </span>


        <span>

            <x-ui.icon name="star" />

            {{ $company->rating ?? 0 }}

        </span>


    </div>


    <div class="company-comments">

        <x-ui.icon name="comments" />

        {{ $company->reviews_count ?? 0 }} نظر

    </div>



    <a href="{{ route('company.profile', $company->slug) }}"
       class="company-profile-btn">


        مشاهده پروفایل


        <x-ui.icon name="arrow-left" />


    </a>


</div>
