@props([
    'dollar' => [
        'price' => 0,
        'change' => 0,
        'date' => null,
    ]
])


<div class="hero-dollar-widget">


    <div class="dollar-live">
        <span></span>
        LIVE
    </div>


    <div class="dollar-title">
        USD
    </div>


    <div class="dollar-price">

        {{ number_format($dollar['price'] ?? 0) }}

        <small>
            ریال
        </small>

    </div>


    <div class="dollar-change
        {{ ($dollar['change'] ?? 0) < 0 ? 'down' : 'up' }}">

        @if(($dollar['change'] ?? 0) < 0)
            
        @else

        @endif

        {{ number_format(abs($dollar['change'] ?? 0)) }}

    </div>


</div>
