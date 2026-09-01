<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <x-ui.icon name="calendar-days" />

            <strong>

                {{ $store->experience ?? 0 }}

            </strong>

            <span>

                سال سابقه

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="boxes-stacked" />

            <strong>

                {{ $store->products_count ?? 0 }}

            </strong>

            <span>

                محصول

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="tags" />

            <strong>

                {{ $store->brands_count ?? 0 }}

            </strong>

            <span>

                برند

            </span>

        </div>





        <div class="stat-item">

            <x-ui.icon name="star" />

            <strong>

                {{ $store->rating ?? 0 }}

            </strong>

            <span>

                امتیاز

            </span>

        </div>



    </div>


</section>
