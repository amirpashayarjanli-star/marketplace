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


                <x-ui.icon name="circle-check" />


                تایید شده آسانسور پرو


            </div>

            @endif






            <h1>

                {{ $company->name }}

            </h1>







            <div class="profile-meta">



                <span>

                    <x-ui.icon name="location-dot" />

                    {{ $company->city }}

                </span>





                <span>

                    <x-ui.icon name="star" />

                    {{ $company->rating ?? 0 }}

                </span>





                <span>

                    <x-ui.icon name="comments" />

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
