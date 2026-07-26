<section class="profile-hero">


    <div class="profile-hero-card">



        <div class="profile-logo">


            <img

            src="{{ asset($manufacturer->logo ?? 'images/logo/logo.svg') }}"

            alt="{{ $manufacturer->name }}">


        </div>








        <div class="profile-info">



            @if($manufacturer->is_verified)

            <div class="profile-verified">


                <i class="fa-solid fa-circle-check"></i>


                تایید شده آسانسور پرو


            </div>

            @endif







            <h1>

                {{ $manufacturer->name }}


            </h1>









            <div class="profile-meta">



                <span>

                    <i class="fa-solid fa-location-dot"></i>


                    {{ $manufacturer->city }}


                </span>








                <span>

                    <i class="fa-solid fa-star"></i>


                    {{ $manufacturer->rating }}


                </span>








                <span>

                    <i class="fa-solid fa-industry"></i>


                    تولیدکننده تجهیزات آسانسور


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

                    درب آسانسور

                </span>



            </div>









            <div class="profile-actions">



                <a href="#"

                   class="btn-primary">


                    تماس با تولیدکننده


                </a>



            </div>





        </div>




    </div>



</section>
