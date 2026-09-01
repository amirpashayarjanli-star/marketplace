@extends('dashboard.layouts.dashboard')


@section('content')


<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold">مزایده‌های من</h1>
    <a href="{{ route('dashboard.auctions.create') }}"
       class="bg-blue-600 text-white px-5 py-3 rounded-xl">➕ مزایده جدید</a>
</div>


@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">{{ session('error') }}</div>
@endif


<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    @forelse($auctions as $auction)

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold">{{ $auction->title }}</h2>
                <span class="text-xs font-bold px-2 py-1 rounded
                    @class([
                        'bg-amber-100 text-amber-700'  => in_array($auction->status, ['pending_review','awaiting_consultation']),
                        'bg-green-100 text-green-700'   => $auction->status === 'active',
                        'bg-blue-100 text-blue-700'     => $auction->status === 'awarded',
                        'bg-slate-100 text-slate-600'   => in_array($auction->status, ['closed','draft']),
                        'bg-red-100 text-red-700'       => $auction->status === 'cancelled',
                    ])">
                    {{ $auction->statusLabel() }}
                </span>
            </div>

            <div class="space-y-1 text-gray-600 text-sm">
                <p>{{ \App\Models\Auction::SCOPES[$auction->scope] ?? $auction->scope }}</p>
                <p>📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}</p>
                <p>{{ $auction->bids_count }} پیشنهاد فعال</p>
                @if($auction->ends_at)
                    <p>پایان مهلت: {{ jdatetime($auction->ends_at) }}</p>
                @endif
            </div>

            @if($auction->source === 'onsite' && ! in_array($auction->status, ['cancelled','awarded']) && ! $auction->readyToPublish())
                <div class="mt-3 rounded-xl bg-amber-50 border border-amber-200 p-3 text-sm text-amber-800">
                    ☎️ برای انتشار، مرحله‌ی مشاوره را کامل کنید.
                </div>
            @endif

            <a href="{{ route('dashboard.auctions.show', $auction) }}"
               class="inline-block mt-4 text-blue-600 text-sm">
                @if($auction->source === 'onsite' && ! $auction->readyToPublish() && ! in_array($auction->status, ['cancelled','awarded']))
                    تکمیل مشاوره ←
                @else
                    مدیریت و انتخاب برنده ←
                @endif
            </a>

        </div>

    @empty

        <div class="bg-white rounded-2xl shadow p-6 md:col-span-2">
            <p class="text-gray-500">هنوز مزایده‌ای نساخته‌اید.</p>
            <a href="{{ route('dashboard.auctions.create') }}"
               class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded-xl">ساخت اولین مزایده</a>
        </div>

    @endforelse

</div>


@endsection
