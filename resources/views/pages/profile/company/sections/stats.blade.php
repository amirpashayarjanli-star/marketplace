<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <i class="fa-solid fa-calendar-days"></i>

            <strong>

                {{ $company->experience ?? 0 }}

            </strong>

            <span>

                سال تجربه

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-building"></i>

            <strong>

                {{ $company->projects_count ?? 0 }}

            </strong>

            <span>

                پروژه انجام شده

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-star"></i>

            <strong>

                {{ $company->rating ?? 0 }}

            </strong>

            <span>

                امتیاز

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-comments"></i>

            <strong>

                {{ $company->reviews_count ?? 0 }}

            </strong>

            <span>

                نظر ثبت شده

            </span>

        </div>



    </div>


</section>
