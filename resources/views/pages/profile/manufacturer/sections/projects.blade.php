<section class="profile-projects">


    <div class="section-title">

        <h2>

            پروژه‌ها

        </h2>

    </div>





    <div class="projects-grid">


        @if($manufacturer->projects && $manufacturer->projects->count())


            @foreach($manufacturer->projects as $project)


                <div class="project-card">


                    @if($project->image)

                    <div class="project-image">


                        <img

                        src="{{ asset($project->image) }}"

                        alt="{{ $project->title }}">


                    </div>

                    @endif





                    <h3>

                        {{ $project->title }}

                    </h3>





                    <div class="project-meta">


                        <span>

                            <i class="fa-solid fa-location-dot"></i>

                            {{ $project->city }}

                        </span>



                        <span>

                            <i class="fa-solid fa-building"></i>

                            {{ $project->type }}

                        </span>


                    </div>



                </div>


            @endforeach


        @else


            <div class="empty-data">

                پروژه‌ای ثبت نشده است.

            </div>


        @endif



    </div>


</section>
