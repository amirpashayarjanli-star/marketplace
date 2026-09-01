<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <x-ui.icon name="calendar-days" />

            <strong>

                {{ $company->experience ?? 0 }}

            </strong>

            <span>

                سال تجربه

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="building" />

            <strong>

                {{ $company->projects_count ?? 0 }}

            </strong>

            <span>

                پروژه انجام شده

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="star" />

            <strong>

                {{ $company->rating ?? 0 }}

            </strong>

            <span>

                امتیاز

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="comments" />

            <strong>

                {{ $company->reviews_count ?? 0 }}

            </strong>

            <span>

                نظر ثبت شده

            </span>

        </div>



    </div>


</section>
