<section class="profile-hero">


    <div class="profile-hero-card">



        <div class="profile-logo">


            <img

            src="{{ asset($company->logo ?? 'images/logo/logo.svg') }}"

            alt="{{ $company->name }}">


        </div>








        <div class="profile-info">





            @if($company->is_verified)

            <div class="profile-verified">


                <i class="fa-solid fa-circle-check"></i>


                تایید شده آسانسور پرو


            </div>

            @endif







            <h1>

                {{ $company->name }}


            </h1>








            <div class="profile-meta">



                <span>

                    <i class="fa-solid fa-location-dot"></i>

                    {{ $company->city }}


                </span>








                <span>

                    <i class="fa-solid fa-star"></i>

                    {{ $company->rating }}


                </span>








                <span>

                    <i class="fa-solid fa-comments"></i>

                    {{ $company->reviews_count }} نظر


                </span>



            </div>








            <div class="profile-actions">


                <a href="#"

                   class="btn-primary">


                    تماس با شرکت


                </a>





                <a href="#"

                   class="btn-secondary">


                    درخواست همکاری


                </a>


            </div>





        </div>




    </div>



</section>
