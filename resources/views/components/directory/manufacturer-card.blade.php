<div class="company-card manufacturer-card">


    <div class="company-logo">


        <img
            src="{{ asset($manufacturer->logo ?? 'images/logo/logo.svg') }}"
            alt="{{ $manufacturer->name }}">


    </div>





    <h3>

        {{ $manufacturer->name }}

    </h3>





    <div class="manufacturer-type">


        <i class="fa-solid fa-industry"></i>


        تولیدکننده تجهیزات آسانسور


    </div>








    <div class="company-info">



        <span>


            <i class="fa-solid fa-location-dot"></i>


            {{ $manufacturer->city }}


        </span>





        <span>


            <i class="fa-solid fa-star"></i>


            {{ $manufacturer->rating }}


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


        <i class="fa-solid fa-comments"></i>


        {{ $manufacturer->reviews_count }} نظر



    </div>









    <a href="#"
       class="company-profile-btn">


        مشاهده پروفایل


        <i class="fa-solid fa-arrow-left"></i>


    </a>



</div>
