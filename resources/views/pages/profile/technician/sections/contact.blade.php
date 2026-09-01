<section class="profile-contact">


    <div class="section-title">

        <h2>

            ارتباط با تکنسین

        </h2>

    </div>





    <div class="contact-info">


        @if($technician->phone)

        <div class="contact-item">

            <x-ui.icon name="phone" />

            <a href="tel:{{ $technician->phone }}">

                {{ $technician->phone }}

            </a>

        </div>

        @endif





        @if($technician->mobile)

        <div class="contact-item">

            <x-ui.icon name="mobile-screen" />

            <a href="tel:{{ $technician->mobile }}">

                {{ $technician->mobile }}

            </a>

        </div>

        @endif





        @if($technician->address)

        <div class="contact-item">

            <x-ui.icon name="location-dot" />

            <span>

                {{ $technician->address }}

            </span>

        </div>

        @endif



    </div>


</section>
