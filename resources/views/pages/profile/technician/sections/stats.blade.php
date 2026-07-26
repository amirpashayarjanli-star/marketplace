<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <i class="fa-solid fa-calendar-days"></i>

            <strong>

                {{ $technician->experience ?? 0 }}

            </strong>

            <span>

                سال تجربه

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-building"></i>

            <strong>

                {{ $technician->projects_count ?? 0 }}

            </strong>

            <span>

                پروژه انجام شده

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-screwdriver-wrench"></i>

            <strong>

                {{ $technician->repairs_count ?? 0 }}

            </strong>

            <span>

                تعمیر انجام شده

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-star"></i>

            <strong>

                {{ $technician->rating ?? 0 }}

            </strong>

            <span>

                امتیاز

            </span>

        </div>



    </div>


</section>  
