<section class="profile-hero">


    <div class="profile-hero-card">


        <div class="profile-logo">


            <img

            src="{{ asset($manufacturer->logo ?? 'images/logo/logo.svg') }}"

            alt="{{ $manufacturer->name }}">


        </div>





        <div class="profile-info">



            @if($manufacturer->is_verified)

            <div class="profile-verified">


                <x-ui.icon name="circle-check" />


                تایید شده آسانسور پرو


            </div>

            @endif





            <h1>

                {{ $manufacturer->name }}

            </h1>







            <div class="profile-meta">


                <span>

                    <x-ui.icon name="location-dot" />

                    {{ $manufacturer->city }}

                </span>




                <span>

                    <x-ui.icon name="star" />

                    {{ $manufacturer->rating ?? 0 }}

                </span>




                <span>

                    <x-ui.icon name="industry" />

                    تولیدکننده تجهیزات آسانسور

                </span>



            </div>







            @if(isset($manufacturer->products))


            <div class="manufacturer-tags">


                @foreach($manufacturer->products->take(4) as $product)


                <span>

                    {{ $product->name }}

                </span>


                @endforeach


            </div>


            @endif







            <div class="profile-actions">



                @if($manufacturer->phone || $manufacturer->mobile)

                <a href="tel:{{ $manufacturer->phone ?? $manufacturer->mobile }}"

                   class="btn-primary">


                    تماس با تولیدکننده


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
