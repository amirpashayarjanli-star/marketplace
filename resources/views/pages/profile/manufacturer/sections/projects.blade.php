<section class="profile-projects">


    <div class="profile-section-card">



        <div class="section-title">


            <i class="fa-solid fa-building"></i>


            پروژه‌های مرتبط



        </div>







        <div class="profile-project-grid">



            @forelse($manufacturer->projects as $project)



                <div class="profile-project-card">



                    <div class="project-thumb">


                        <img

                        src="{{ asset($project->image ?? 'images/logo/company-logo.png') }}"

                        alt="{{ $project->title }}">


                    </div>







                    <h3>

                        {{ $project->title }}

                    </h3>







                    <span>

                        <i class="fa-solid fa-location-dot"></i>

                        {{ $project->city }}

                    </span>







                    <span>

                        {{ $project->type }}

                    </span>





                </div>




            @empty



                <p>

                    هنوز پروژه‌ای ثبت نشده است.

                </p>



            @endforelse





        </div>




    </div>


</section>
