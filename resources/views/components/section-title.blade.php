@props([
    'title',
    'description' => '',
    'url' => '#',
    'button' => 'مشاهده همه'
])

<div class="section-header">

    <div class="section-header-right">

        <span class="section-subtitle">
            آسانسور پرو
        </span>

        <h2>{{ $title }}</h2>

        @if($description)
            <p>{{ $description }}</p>
        @endif

    </div>

    <div class="section-header-left">

        <a
            href="{{ $url }}"
            class="view-all">

            {{ $button }}

            <i class="fa-solid fa-arrow-left"></i>

        </a>

    </div>

</div>