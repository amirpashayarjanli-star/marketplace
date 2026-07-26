<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <i class="fa-solid fa-calendar-days"></i>

            <strong>

                {{ $manufacturer->experience ?? 0 }}

            </strong>

            <span>

                سال تجربه

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-boxes-stacked"></i>

            <strong>

                {{ $manufacturer->products_count ?? 0 }}

            </strong>

            <span>

                محصول

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-users"></i>

            <strong>

                {{ $manufacturer->customers_count ?? 0 }}

            </strong>

            <span>

                مشتری

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-star"></i>

            <strong>

                {{ $manufacturer->rating ?? 0 }}

            </strong>

            <span>

                امتیاز

            </span>

        </div>



    </div>


</section>
