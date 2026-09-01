<section class="profile-projects">


    <div class="section-title">

        <h2>

            پروژه‌ها

        </h2>

    </div>





    <div class="projects-grid">


        @if($technician->projects && $technician->projects->count())


            @foreach($technician->projects as $project)


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

                            <x-ui.icon name="location-dot" />

                            {{ $project->city }}

                        </span>



                        <span>

                            <x-ui.icon name="building" />

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
