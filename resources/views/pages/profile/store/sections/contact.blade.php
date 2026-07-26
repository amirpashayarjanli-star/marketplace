<section class="profile-contact">


    <div class="section-title">

        <h2>

            ارتباط با فروشگاه

        </h2>

    </div>





    <div class="contact-info">


        @if($store->phone)

        <div class="contact-item">

            <i class="fa-solid fa-phone"></i>

            <a href="tel:{{ $store->phone }}">

                {{ $store->phone }}

            </a>

        </div>

        @endif





        @if($store->mobile)

        <div class="contact-item">

            <i class="fa-solid fa-mobile-screen"></i>

            <a href="tel:{{ $store->mobile }}">

                {{ $store->mobile }}

            </a>

        </div>

        @endif





        @if($store->website)

        <div class="contact-item">

            <i class="fa-solid fa-globe"></i>

            <a href="{{ $store->website }}" target="_blank">

                وب‌سایت فروشگاه

            </a>

        </div>

        @endif





        @if($store->address)

        <div class="contact-item">

            <i class="fa-solid fa-location-dot"></i>

            <span>

                {{ $store->address }}

            </span>

        </div>

        @endif



    </div>


</section>
