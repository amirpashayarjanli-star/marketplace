<section class="profile-contact">


    <div class="section-title">

        <h2>

            ارتباط با تکنسین

        </h2>

    </div>





    <div class="contact-info">


        @if($technician->phone)

        <div class="contact-item">

            <i class="fa-solid fa-phone"></i>

            <a href="tel:{{ $technician->phone }}">

                {{ $technician->phone }}

            </a>

        </div>

        @endif





        @if($technician->mobile)

        <div class="contact-item">

            <i class="fa-solid fa-mobile-screen"></i>

            <a href="tel:{{ $technician->mobile }}">

                {{ $technician->mobile }}

            </a>

        </div>

        @endif





        @if($technician->address)

        <div class="contact-item">

            <i class="fa-solid fa-location-dot"></i>

            <span>

                {{ $technician->address }}

            </span>

        </div>

        @endif



    </div>


</section>
