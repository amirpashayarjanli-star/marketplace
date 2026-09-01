@extends('dashboard.layouts.dashboard')


@section('content')


<div class="auction-board-head">

    <div>
        <h1>مزایده‌های من</h1>
        <p>پروژه‌هایی که برای دریافت پیشنهاد ثبت کرده‌اید.</p>
    </div>

    <a href="{{ route('dashboard.auctions.create') }}" class="btn btn-primary">
        مزایده جدید
    </a>

</div>


@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif


<div class="auction-board-list">

    @forelse($auctions as $auction)

        @php
            $needsConsultation = $auction->source === 'onsite'
                && ! $auction->readyToPublish()
                && ! in_array($auction->status, ['cancelled', 'awarded']);
        @endphp

        <div class="card auction-board-item">

            <div class="auction-board-item-main">

                <h2>{{ $auction->title }}</h2>

                <p class="auction-board-item-meta">
                    {{ \App\Models\Auction::SCOPES[$auction->scope] ?? $auction->scope }}
                    &nbsp;·&nbsp;
                    📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}
                </p>

                <p class="auction-board-item-meta">
                    {{ $auction->bids_count }} پیشنهاد فعال
                    @if($auction->ends_at)
                        &nbsp;·&nbsp; پایان مهلت: {{ jdatetime($auction->ends_at) }}
                    @endif
                </p>

                @if($needsConsultation)
                    <p class="auction-note" style="margin-top:12px;">
                        ☎️ برای انتشار، مرحله‌ی مشاوره را کامل کنید.
                    </p>
                @endif

            </div>

            <div class="auction-board-item-side">

                <span @class([
                    'badge',
                    'badge-warning' => in_array($auction->status, ['pending_review', 'awaiting_consultation']),
                    'badge-success' => $auction->status === 'active',
                    'badge-danger'  => $auction->status === 'cancelled',
                ])>{{ $auction->statusLabel() }}</span>

                <a href="{{ route('dashboard.auctions.show', $auction) }}" class="btn btn-sm btn-outline">
                    {{ $needsConsultation ? 'تکمیل مشاوره' : 'مدیریت و انتخاب برنده' }}
                </a>

            </div>

        </div>

    @empty

        <div class="auction-board-empty">
            <p>هنوز مزایده‌ای نساخته‌اید.</p>
            <a href="{{ route('dashboard.auctions.create') }}" class="btn btn-primary">ساخت اولین مزایده</a>
        </div>

    @endforelse

</div>


@endsection
