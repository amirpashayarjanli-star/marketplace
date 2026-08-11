<div class="company-card technician-card">



    <div class="company-logo">


        <img
            src="{{ asset($technician->avatar ?? 'images/logo/company-logo.png') }}"
            alt="{{ $technician->name }}">


    </div>








    <h3>

        {{ $technician->name }}

    </h3>








    <div class="technician-status">


        <span></span>


        فعال


    </div>








    <div class="company-info">



        <span>


            <i class="fa-solid fa-location-dot"></i>


            {{ $technician->city }}


        </span>







        <span>


            <i class="fa-solid fa-star"></i>


            {{ $technician->rating }}


        </span>



    </div>









    <div class="technician-skills">


        <span>
            تعمیرات
        </span>


        <span>
            نصب
        </span>


        <span>
            عیب‌یابی
        </span>


    </div>









    <div class="company-comments">


        <i class="fa-solid fa-comments"></i>


        {{ $technician->reviews_count }} نظر



    </div>









    <div class="technician-jobs">


        {{ $technician->projects_count }} پروژه انجام شده


    </div>









    <a href="{{ route('technician.profile', $technician->slug) }}"
       class="company-profile-btn">


        مشاهده پروفایل


        <i class="fa-solid fa-arrow-left"></i>


    </a>




</div>
