<section class="profile-hero">


    <div class="profile-hero-card">



        <div class="profile-logo technician-avatar">


            <img

            src="{{ asset($technician->avatar ?? 'images/logo/company-logo.png') }}"

            alt="{{ $technician->name }}">


        </div>








        <div class="profile-info">



            @if($technician->is_verified)

            <div class="profile-verified">


                <i class="fa-solid fa-circle-check"></i>


                تایید شده آسانسور پرو


            </div>

            @endif







            <h1>

                {{ $technician->name }}


            </h1>









            <div class="profile-meta">



                <span>

                    <i class="fa-solid fa-location-dot"></i>

                    {{ $technician->city }}


                </span>








                <span>

                    <i class="fa-solid fa-star"></i>

                    {{ $technician->rating }}


                </span>








                <span>

                    <i class="fa-solid fa-screwdriver-wrench"></i>

                    تکنسین نصب و تعمیر آسانسور


                </span>



            </div>









            <div class="manufacturer-tags">



                <span>

                    نصب آسانسور

                </span>



                <span>

                    تعمیر تابلو فرمان

                </span>



                <span>

                    تعمیر موتور

                </span>



                <span>

                    تنظیم درب

                </span>



            </div>









            <div class="profile-actions">



                <a href="#"

                   class="btn-primary">


                    درخواست تکنسین


                </a>



            </div>





        </div>




    </div>



</section>  
