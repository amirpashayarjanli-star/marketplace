<div class="company-card project-card">



    <div class="project-image">


        <img

        src="{{ asset($project->image ?? 'images/logo/company-logo.png') }}"

        alt="{{ $project->title }}">


    </div>








    <h3>

        {{ $project->title }}

    </h3>









    <div class="company-info">



        <span>


            <i class="fa-solid fa-location-dot"></i>


            {{ $project->city }}


        </span>








        <span>


            <i class="fa-solid fa-building"></i>


            {{ $project->type }}


        </span>



    </div>









    <div class="project-status">


        <span></span>


        تایید شده



    </div>









    @if($project->company)


        <div class="project-company">


            <i class="fa-solid fa-building-circle-check"></i>


            {{ $project->company->name }}


        </div>


    @endif







    <a href="{{ route('project.profile', $project->slug) }}"

       class="company-profile-btn">



        مشاهده پروژه


        <i class="fa-solid fa-arrow-left"></i>



    </a>






</div>
