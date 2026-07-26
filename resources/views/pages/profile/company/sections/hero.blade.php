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

                    {{ $company->rating ?? 0 }}

                </span>





                <span>

                    <i class="fa-solid fa-comments"></i>

                    {{ $company->reviews_count ?? 0 }} نظر

                </span>



            </div>








            @if($company->services)


            <div class="manufacturer-tags">


                @foreach($company->services as $service)


                <span>

                    {{ $service->name }}

                </span>


                @endforeach


            </div>


            @endif







            <div class="profile-actions">



                @if($company->phone || $company->mobile)

                <a href="tel:{{ $company->phone ?? $company->mobile }}"

                   class="btn-primary">


                    تماس با شرکت


                </a>

                @endif





                <a href="#contact"

                   class="btn-secondary">


                    درخواست همکاری


                </a>



            </div>





        </div>




    </div>



</section>
