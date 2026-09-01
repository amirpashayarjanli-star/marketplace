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


            <x-ui.icon name="location-dot" />


            {{ $technician->city }}


        </span>







        <span>


            <x-ui.icon name="star" />


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


        <x-ui.icon name="comments" />


        {{ $technician->reviews_count }} نظر



    </div>









    <div class="technician-jobs">


        {{ $technician->projects_count }} پروژه انجام شده


    </div>









    <a href="{{ route('technician.profile', $technician->slug) }}"
       class="company-profile-btn">


        مشاهده پروفایل


        <x-ui.icon name="arrow-left" />


    </a>




</div>
