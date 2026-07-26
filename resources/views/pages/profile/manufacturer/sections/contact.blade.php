<section class="profile-contact">


    <div class="section-title">

        <h2>

            ارتباط با تولیدکننده

        </h2>

    </div>





    <div class="contact-info">


        @if($manufacturer->phone)

        <div class="contact-item">

            <i class="fa-solid fa-phone"></i>

            <a href="tel:{{ $manufacturer->phone }}">

                {{ $manufacturer->phone }}

            </a>

        </div>

        @endif





        @if($manufacturer->mobile)

        <div class="contact-item">

            <i class="fa-solid fa-mobile-screen"></i>

            <a href="tel:{{ $manufacturer->mobile }}">

                {{ $manufacturer->mobile }}

            </a>

        </div>

        @endif





        @if($manufacturer->website)

        <div class="contact-item">

            <i class="fa-solid fa-globe"></i>

            <a href="{{ $manufacturer->website }}" target="_blank">

                وب‌سایت تولیدکننده

            </a>

        </div>

        @endif





        @if($manufacturer->address)

        <div class="contact-item">

            <i class="fa-solid fa-location-dot"></i>

            <span>

                {{ $manufacturer->address }}

            </span>

        </div>

        @endif



    </div>


</section>
