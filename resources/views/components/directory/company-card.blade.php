<div class="company-card">


    <div class="company-logo">


        <img
        src="{{ asset($company['logo']) }}"
        alt="{{ $company['name'] }}">


    </div>



    <h3>

        {{ $company['name'] }}

    </h3>



    <div class="company-info">


        <span>

            <i class="fa-solid fa-location-dot"></i>

            {{ $company['city'] }}

        </span>



        <span>

            <i class="fa-solid fa-star"></i>

            {{ $company['rating'] }}

        </span>


    </div>




    <div class="company-comments">


        <i class="fa-solid fa-comments"></i>

        {{ $company['comments'] }} نظر


    </div>



    <a href="#"
       class="company-profile-btn">

        مشاهده پروفایل

    </a>



</div>
