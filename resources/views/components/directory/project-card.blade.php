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


            <x-ui.icon name="location-dot" />


            {{ $project->city }}


        </span>








        <span>


            <x-ui.icon name="building" />


            {{ $project->type }}


        </span>



    </div>









    <div class="project-status">


        <span></span>


        تایید شده



    </div>









    @if($project->company)


        <div class="project-company">


            <x-ui.icon name="building-circle-check" />


            {{ $project->company->name }}


        </div>


    @endif







    <a href="{{ route('project.profile', $project->slug) }}"

       class="company-profile-btn">



        مشاهده پروژه


        <x-ui.icon name="arrow-left" />



    </a>






</div>
