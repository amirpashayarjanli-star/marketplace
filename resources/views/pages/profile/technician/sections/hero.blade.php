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


                <x-ui.icon name="circle-check" />


                تایید شده آسانسور پرو


            </div>

            @endif





            <h1>

                {{ $technician->name }}

            </h1>







            <div class="profile-meta">



                <span>

                    <x-ui.icon name="location-dot" />

                    {{ $technician->city }}

                </span>





                <span>

                    <x-ui.icon name="star" />

                    {{ $technician->rating ?? 0 }}

                </span>





                <span>

                    <x-ui.icon name="screwdriver-wrench" />

                    تکنسین آسانسور

                </span>



            </div>







            @php
                // skills در دیتابیس یک ستون text است و با ویرگول جدا می‌شود،
                // نه رابطه و نه آرایه. اینجا به لیست تمیز تبدیلش می‌کنیم.
                $skillList = collect(
                        is_array($technician->skills)
                            ? $technician->skills
                            : preg_split('/[،,]/u', (string) $technician->skills)
                    )
                    ->map(fn ($skill) => trim((string) $skill))
                    ->filter()
                    ->values();
            @endphp


            @if($skillList->isNotEmpty())


            <div class="manufacturer-tags">


                @foreach($skillList as $skill)


                <span>

                    {{ $skill }}

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
