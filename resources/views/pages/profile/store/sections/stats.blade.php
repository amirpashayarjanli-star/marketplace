<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <i class="fa-solid fa-calendar-days"></i>

            <strong>

                {{ $store->experience ?? 0 }}

            </strong>

            <span>

                سال سابقه

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-boxes-stacked"></i>

            <strong>

                {{ $store->products_count ?? 0 }}

            </strong>

            <span>

                محصول

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-tags"></i>

            <strong>

                {{ $store->brands_count ?? 0 }}

            </strong>

            <span>

                برند

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-star"></i>

            <strong>

                {{ $store->rating ?? 0 }}

            </strong>

            <span>

                امتیاز

            </span>

        </div>



    </div>


</section>
