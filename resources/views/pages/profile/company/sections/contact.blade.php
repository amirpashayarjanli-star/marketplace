<section class="profile-contact">


    <div class="section-title">

        <h2>

            ارتباط با شرکت

        </h2>

    </div>





    <div class="contact-info">


        @if($company->phone)

        <div class="contact-item">

            <i class="fa-solid fa-phone"></i>

            <a href="tel:{{ $company->phone }}">

                {{ $company->phone }}

            </a>

        </div>

        @endif





        @if($company->mobile)

        <div class="contact-item">

            <i class="fa-solid fa-mobile-screen"></i>

            <a href="tel:{{ $company->mobile }}">

                {{ $company->mobile }}

            </a>

        </div>

        @endif





        @if($company->website)

        <div class="contact-item">

            <i class="fa-solid fa-globe"></i>

            <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">
                وب‌سایت شرکت
            </a>

        </div>

        @endif





        @if($company->address)

        <div class="contact-item">

            <i class="fa-solid fa-location-dot"></i>

            <span>

                {{ $company->address }}

            </span>

        </div>

        @endif



    </div>


</section>
