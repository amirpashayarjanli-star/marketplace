@extends('dashboard.layouts.dashboard')


@section('content')


<div class="auction-board-head">

    <div>
        <h1>پیشنهادهای مزایده‌ی من</h1>
        <p>مزایده‌هایی که در آن‌ها پیشنهاد قیمت داده‌اید.</p>
    </div>

    <a href="{{ route('auctions.index') }}" class="btn btn-outline">
        مشاهده‌ی همه‌ی مزایده‌ها
    </a>

</div>


@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif


<div class="auction-board-list">

    @forelse($bids as $bid)

        <a href="{{ route('auction.show', $bid->auction->slug) }}" class="card auction-board-item">

            <div class="auction-board-item-main">

                <h2>{{ $bid->auction->title }}</h2>

                <p class="auction-board-item-meta">
                    وضعیت مزایده: {{ $bid->auction->statusLabel() }}
                    @if($bid->delivery_days)
                        &nbsp;·&nbsp; زمان تحویل: {{ $bid->delivery_days }} روز
                    @endif
                </p>

                @if($bid->auction->ends_at)
                    <p class="auction-board-item-meta">
                        پایان مهلت: {{ jdatetime($bid->auction->ends_at) }}
                    </p>
                @endif

            </div>

            <div class="auction-board-item-side">

                <span @class([
                    'badge',
                    'badge-success' => $bid->status === 'won',
                    'badge-danger'  => $bid->status === 'withdrawn',
                ])>
                    @switch($bid->status)
                        @case('active') فعال @break
                        @case('won') برنده @break
                        @case('lost') بازنده @break
                        @default انصراف
                    @endswitch
                </span>

                <span class="auction-board-amount">{{ number_format($bid->amount) }} تومان</span>

            </div>

        </a>

    @empty

        <div class="auction-board-empty">
            <p>هنوز در هیچ مزایده‌ای پیشنهاد نداده‌اید.</p>
            <a href="{{ route('auctions.index') }}" class="btn btn-primary">مشاهده‌ی مزایده‌ها</a>
        </div>

    @endforelse

</div>


@endsection
