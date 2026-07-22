<div class="entity-card">

    <div class="entity-card__cover">

        <img
            src="{{ $item->cover ?? asset('images/company-cover.jpg') }}"
            alt="{{ $item->name }}"
            loading="lazy">


        @if($item->verified ?? false)

            <span class="entity-badge">

                <i class="fa-solid fa-badge-check"></i>

                تایید شده

            </span>

        @endif


    </div>



    <div class="entity-card__body">


        <div class="entity-logo">

            <img
                src="{{ $item->logo ?? asset('images/company-logo.png') }}"
                alt="{{ $item->name }}"
                loading="lazy">

        </div>



        <h3 class="entity-title">

            {{ $item->name }}

        </h3>



        <div class="entity-city">

            <i class="fa-solid fa-location-dot"></i>

            {{ $item->city ?? '---' }}

        </div>



        <div class="entity-stats">


            <div>

                <i class="fa-solid fa-star"></i>

                <span>
                    {{ number_format($item->rating ?? 0,1) }}
                </span>

            </div>



            <div>

                <i class="fa-solid fa-diagram-project"></i>

                <span>
                    {{ $item->projects_count ?? 0 }}
                </span>

            </div>


        </div>



        <a
            href="#"
            class="entity-button">

            مشاهده پروفایل

        </a>


    </div>


</div>