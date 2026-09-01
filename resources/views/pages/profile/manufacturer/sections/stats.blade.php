<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <x-ui.icon name="calendar-days" />

            <strong>

                {{ $manufacturer->experience ?? 0 }}

            </strong>

            <span>

                سال تجربه

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="boxes-stacked" />

            <strong>

                {{ $manufacturer->products_count ?? 0 }}

            </strong>

            <span>

                محصول

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="users" />

            <strong>

                {{ $manufacturer->customers_count ?? 0 }}

            </strong>

            <span>

                مشتری

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="star" />

            <strong>

                {{ $manufacturer->rating ?? 0 }}

            </strong>

            <span>

                امتیاز

            </span>

        </div>



    </div>


</section>
