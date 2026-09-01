<section class="profile-contact">


    <div class="section-title">

        <h2>

            ارتباط با شرکت

        </h2>

    </div>





    <div class="contact-info">


        @if($company->phone)

        <div class="contact-item">

            <x-ui.icon name="phone" />

            <a href="tel:{{ $company->phone }}">

                {{ $company->phone }}

            </a>

        </div>

        @endif





        @if($company->mobile)

        <div class="contact-item">

            <x-ui.icon name="mobile-screen" />

            <a href="tel:{{ $company->mobile }}">

                {{ $company->mobile }}

            </a>

        </div>

        @endif





        @if($company->website)

        <div class="contact-item">

            <x-ui.icon name="globe" />

            <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">
                وب‌سایت شرکت
            </a>

        </div>

        @endif





        @if($company->address)

        <div class="contact-item">

            <x-ui.icon name="location-dot" />

            <span>

                {{ $company->address }}

            </span>

        </div>

        @endif



    </div>


</section>
