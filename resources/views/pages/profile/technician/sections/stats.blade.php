<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <x-ui.icon name="calendar-days" />

            <strong>

                {{ $technician->experience ?? 0 }}

            </strong>

            <span>

                سال تجربه

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="building" />

            <strong>

                {{ $technician->projects_count ?? 0 }}

            </strong>

            <span>

                پروژه انجام شده

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="screwdriver-wrench" />

            <strong>

                {{ $technician->repairs_count ?? 0 }}

            </strong>

            <span>

                تعمیر انجام شده

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="star" />

            <strong>

                {{ $technician->rating ?? 0 }}

            </strong>

            <span>

                امتیاز

            </span>

        </div>



    </div>


</section>  
