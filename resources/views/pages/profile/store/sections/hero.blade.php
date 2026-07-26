<section class="profile-hero">


    <div class="profile-hero-card">



        <div class="profile-logo">


            <img

            src="{{ asset($store->logo ?? 'images/logo/logo.svg') }}"

            alt="{{ $store->name }}">


        </div>








        <div class="profile-info">



            @if($store->is_verified)

            <div class="profile-verified">


                <i class="fa-solid fa-circle-check"></i>


                تایید شده آسانسور پرو


            </div>

            @endif







            <h1>

                {{ $store->name }}


            </h1>









            <div class="profile-meta">



                <span>

                    <i class="fa-solid fa-location-dot"></i>

                    {{ $store->city }}

                </span>








                <span>

                    <i class="fa-solid fa-star"></i>

                    {{ $store->rating }}

                </span>








                <span>

                    <i class="fa-solid fa-shop"></i>

                    فروشگاه قطعات آسانسور

                </span>



            </div>









            <div class="manufacturer-tags">



                <span>

                    موتور آسانسور

                </span>



                <span>

                    تابلو فرمان

                </span>



                <span>

                    قطعات یدکی

                </span>



            </div>









            <div class="profile-actions">



                <a href="#"

                   class="btn-primary">


                    استعلام قیمت


                </a>





                <a href="#"

                   class="btn-secondary">


                    تماس با فروشگاه


                </a>



            </div>





        </div>




    </div>



</section>
