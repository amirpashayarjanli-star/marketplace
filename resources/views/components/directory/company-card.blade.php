<div class="company-card">


    <div class="company-logo">


        <img
            src="{{ asset($company->logo ?? 'images/logo/logo.svg') }}"
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

            {{ $company->rating }}

        </span>



    </div>






    <div class="company-comments">


        <x-ui.icon name="comments" />


        {{ $company->reviews_count }} نظر



    </div>






    <a href="{{ route('company.profile', $company->slug) }}"
       class="company-profile-btn">


        مشاهده پروفایل


    </a>



</div>
