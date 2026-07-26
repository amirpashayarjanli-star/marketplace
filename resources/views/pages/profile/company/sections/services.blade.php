<section class="profile-services">


    <div class="section-title">

        <h2>

            خدمات شرکت

        </h2>

    </div>





    <div class="services-list">


        @if(isset($company->services) && $company->services->count())


            @foreach($company->services as $service)


                <div class="service-item">


                    <i class="fa-solid fa-check"></i>


                    <span>

                        {{ $service->name }}

                    </span>


                </div>


            @endforeach


        @else


            <div class="empty-data">

                خدماتی ثبت نشده است.

            </div>


        @endif



    </div>


</section>
