<section class="profile-hero">


    <div class="profile-hero-card">



        <div class="profile-logo">


            <img

            src="{{ asset($store->logo ?? 'images/logo/logo.svg') }}"

            alt="{{ $store->name }}">


        </div>





        <div class="profile-info">



            @if($store->is_verified)

            <div class="profile-verified">


                <x-ui.icon name="circle-check" />


                تایید شده آسانسور پرو


            </div>

            @endif





            <h1>

                {{ $store->name }}

            </h1>







            <div class="profile-meta">



                <span>

                    <x-ui.icon name="location-dot" />

                    {{ $store->city }}

                </span>





                <span>

                    <x-ui.icon name="star" />

                    {{ $store->rating ?? 0 }}

                </span>





                <span>

                    <x-ui.icon name="shop" />

                    فروشگاه قطعات آسانسور

                </span>



            </div>







            @if($store->products)


            <div class="manufacturer-tags">


                @foreach($store->products->take(4) as $product)


                <span>

                    {{ $product->name }}

                </span>


                @endforeach


            </div>


            @endif







            <div class="profile-actions">



                @if($store->phone || $store->mobile)

                <a href="tel:{{ $store->phone ?? $store->mobile }}"

                   class="btn-primary">


                    تماس با فروشگاه


                </a>

                @endif





                <a href="#contact"

                   class="btn-secondary">


                    استعلام قیمت


                </a>



            </div>




        </div>



    </div>


</section>
