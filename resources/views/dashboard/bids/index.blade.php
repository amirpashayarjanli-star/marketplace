@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">پیشنهادهای مزایده‌ی من</h1>


@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">{{ session('error') }}</div>
@endif


<div class="mb-6">
    <a href="{{ route('auctions.index') }}" class="text-blue-600">← مشاهده‌ی همه‌ی مزایده‌ها</a>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    @forelse($bids as $bid)

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold">
                    <a href="{{ route('auction.show', $bid->auction->slug) }}" class="hover:text-blue-600">
                        {{ $bid->auction->title }}
                    </a>
                </h2>
                <span class="text-xs font-bold px-2 py-1 rounded
                    @class([
                        'bg-blue-100 text-blue-700'   => $bid->status === 'active',
                        'bg-green-100 text-green-700' => $bid->status === 'won',
                        'bg-gray-100 text-gray-600'   => $bid->status === 'lost',
                        'bg-red-100 text-red-700'     => $bid->status === 'withdrawn',
                    ])">
                    @switch($bid->status)
                        @case('active') فعال @break
                        @case('won') برنده @break
                        @case('lost') بازنده @break
                        @default انصراف
                    @endswitch
                </span>
            </div>

            <div class="space-y-1 text-gray-600 text-sm">
                <p>مبلغ پیشنهاد: <strong class="text-gray-800">{{ number_format($bid->amount) }} تومان</strong></p>
                @if($bid->delivery_days)
                    <p>زمان تحویل: {{ $bid->delivery_days }} روز</p>
                @endif
                <p>وضعیت مزایده: {{ $bid->auction->statusLabel() }}</p>
                @if($bid->auction->ends_at)
                    <p>پایان مهلت: {{ jdatetime($bid->auction->ends_at) }}</p>
                @endif
            </div>

            <a href="{{ route('auction.show', $bid->auction->slug) }}"
               class="inline-block mt-4 text-blue-600 text-sm">مشاهده و ویرایش ←</a>

        </div>

    @empty

        <div class="bg-white rounded-2xl shadow p-6 md:col-span-2">
            <p class="text-gray-500">هنوز در هیچ مزایده‌ای پیشنهاد نداده‌اید.</p>
            <a href="{{ route('auctions.index') }}"
               class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded-xl">مشاهده‌ی مزایده‌ها</a>
        </div>

    @endforelse

</div>


@endsection
