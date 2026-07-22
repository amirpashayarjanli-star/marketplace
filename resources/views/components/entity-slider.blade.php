@props([
    'title',
    'description' => '',
    'items' => collect(),
    'type',
    'viewAllUrl' => '#'
])

<section class="entity-slider-section">

    <div class="container">

        <div class="section-header">

            <div class="section-header-right">

                <span class="section-subtitle">
                    آسانسور پرو
                </span>

                <h2>
                    {{ $title }}
                </h2>

                @if($description)
                    <p>
                        {{ $description }}
                    </p>
                @endif

            </div>

            <div class="section-header-left">

                <a
                    href="{{ $viewAllUrl }}"
                    class="view-all">

                    مشاهده همه

                    <i class="fa-solid fa-arrow-left"></i>

                </a>

                <div class="slider-navigation">

                    <button
                        class="slider-arrow slider-prev"
                        type="button">

                        <i class="fa-solid fa-chevron-right"></i>

                    </button>

                    <button
                        class="slider-arrow slider-next"
                        type="button">

                        <i class="fa-solid fa-chevron-left"></i>

                    </button>

                </div>

            </div>

        </div>

        <div class="entity-slider">

            <div class="entity-track">

                @forelse($items as $item)

                    @switch($type)

                        @case('company')
                            @include('components.card-company',['item'=>$item])
                        @break

                        @case('manufacturer')
                            @include('components.card-manufacturer',['item'=>$item])
                        @break

                        @case('store')
                            @include('components.card-store',['item'=>$item])
                        @break

                    @endswitch

                @empty

                    <div class="slider-empty">

                        <i class="fa-regular fa-folder-open"></i>

                        <h3>موردی برای نمایش وجود ندارد</h3>

                    </div>

                @endforelse

            </div>

        </div>

        <div class="slider-pagination"></div>

    </div>

</section>