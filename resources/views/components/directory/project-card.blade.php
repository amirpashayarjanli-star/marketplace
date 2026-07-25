<div class="company-card project-card">



    <div class="project-image">


        <img

        src="{{ asset($project['image']) }}"

        alt="{{ $project['name'] }}">


    </div>







    <h3>

        {{ $project['name'] }}

    </h3>








    <div class="company-info">



        <span>


            <i class="fa-solid fa-location-dot"></i>


            {{ $project['city'] }}


        </span>





        <span>


            <i class="fa-solid fa-building"></i>


            {{ $project['type'] }}


        </span>



    </div>







    <div class="project-status">


        <span></span>


        {{ $project['status'] }}


    </div>







    <a href="#"

       class="company-profile-btn">



        مشاهده پروژه


        <i class="fa-solid fa-arrow-left"></i>



    </a>





</div>
