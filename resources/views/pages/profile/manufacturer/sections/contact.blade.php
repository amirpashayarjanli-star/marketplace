<section class="profile-contact">


    <div class="section-title">

        <h2>

            ارتباط با تولیدکننده

        </h2>

    </div>





    <div class="contact-info">


        @if($manufacturer->phone)

        <div class="contact-item">

            <x-ui.icon name="phone" />

            <a href="tel:{{ $manufacturer->phone }}">

                {{ $manufacturer->phone }}

            </a>

        </div>

        @endif





        @if($manufacturer->mobile)

        <div class="contact-item">

            <x-ui.icon name="mobile-screen" />

            <a href="tel:{{ $manufacturer->mobile }}">

                {{ $manufacturer->mobile }}

            </a>

        </div>

        @endif





        @if($manufacturer->website)

        <div class="contact-item">

            <x-ui.icon name="globe" />

            <a href="{{ $manufacturer->website }}" target="_blank" rel="noopener noreferrer">
                وب‌سایت تولیدکننده
            </a>

        </div>

        @endif





        @if($manufacturer->address)

        <div class="contact-item">

            <x-ui.icon name="location-dot" />

            <span>

                {{ $manufacturer->address }}

            </span>

        </div>

        @endif



    </div>


</section>
