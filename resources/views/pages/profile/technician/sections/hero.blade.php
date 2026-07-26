<section class="profile-hero">


    <div class="profile-hero-card">



        <div class="profile-logo technician-avatar">


            <img

            src="{{ asset($technician->avatar ?? 'images/logo/company-logo.png') }}"

            alt="{{ $technician->name }}">


        </div>





        <div class="profile-info">



            @if($technician->is_verified)

            <div class="profile-verified">


                <i class="fa-solid fa-circle-check"></i>


                تایید شده آسانسور پرو


            </div>

            @endif





            <h1>

                {{ $technician->name }}

            </h1>







            <div class="profile-meta">



                <span>

                    <i class="fa-solid fa-location-dot"></i>

                    {{ $technician->city }}

                </span>





                <span>

                    <i class="fa-solid fa-star"></i>

                    {{ $technician->rating ?? 0 }}

                </span>





                <span>

                    <i class="fa-solid fa-screwdriver-wrench"></i>

                    تکنسین آسانسور

                </span>



            </div>







            @if(isset($technician->skills))


            <div class="manufacturer-tags">


                @foreach($technician->skills as $skill)


                <span>

                    {{ $skill->name }}

                </span>


                @endforeach


            </div>


            @endif







            <div class="profile-actions">



                @if($technician->phone || $technician->mobile)

                <a href="tel:{{ $technician->phone ?? $technician->mobile }}"

                   class="btn-primary">


                    درخواست تکنسین


                </a>

                @endif



            </div>




        </div>



    </div>


</section>
