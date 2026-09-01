@extends('layouts.app')


@section('title','پرو مزایده — مزایده پروژه‌های آسانسوری')


@section('content')


@include('sections.header-inner')



<main class="directory-page">

    <div class="container-app">


        <section class="directory-top">

            <h1>پرو مزایده</h1>

            <p>
                کارفرماها پروژه‌ی آسانسوری را می‌گذارند و شرکت‌ها، تولیدکنندگان و
                تکنسین‌ها پیشنهاد قیمت می‌دهند. همه‌ی پیشنهادها عمومی است و کمترین
                پیشنهاد، پیشرو است.
            </p>

        </section>



        {{-- فراخوان کارفرما — مانور روی مشاوره --}}

        <div class="mb-8 overflow-hidden rounded-2xl border-2 border-amber-300 bg-gradient-to-l from-amber-50 via-white to-white">

            <div class="flex flex-wrap items-center gap-6 p-7">

                <div class="flex-1 min-w-[260px]">
                    @php $consultFee = (int) config('proauction.consultation_fee', 0); @endphp

                    <h2 class="mb-2 text-xl font-extrabold text-slate-800">
                        پروژه‌ی آسانسور دارید؟
                        {{ $consultFee > 0 ? 'مشاوره‌ی تخصصی بگیرید' : 'رایگان مشاوره بگیرید' }}
                    </h2>
                    <p class="mb-3 text-sm leading-7 text-slate-600">
                        کارشناسان آسانسور پرو پروژه‌ی شما را بررسی می‌کنند، برآورد واقعی هزینه می‌دهند
                        و مزایده‌تان را طوری تنظیم می‌کنند که شرکت‌های معتبر رقابت کنند —
                        نه اینکه فقط ارزان‌ترین بیاید.
                    </p>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="rounded-full bg-white px-3 py-1 font-bold text-slate-600 ring-1 ring-slate-200">برآورد کارشناسی هزینه</span>
                        <span class="rounded-full bg-white px-3 py-1 font-bold text-slate-600 ring-1 ring-slate-200">تنظیم شرح فنی</span>
                        <span class="rounded-full bg-white px-3 py-1 font-bold text-slate-600 ring-1 ring-slate-200">راهنمایی انتخاب برنده</span>
                        @if($consultFee > 0)
                            <span class="rounded-full bg-amber-100 px-3 py-1 font-bold text-amber-800">
                                هزینه: {{ number_format($consultFee) }} تومان
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <a href="tel:{{ config('proauction.consultation_phone') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-8 py-4 text-lg font-black text-white shadow-lg transition hover:bg-amber-600">
                        📞 {{ config('proauction.consultation_phone') }}
                    </a>

                    <a href="{{ route('dashboard.auctions.create') }}"
                       class="rounded-xl border border-slate-300 bg-white px-8 py-3 text-center text-sm font-bold text-slate-700 transition hover:border-amber-400">
                        ثبت پروژه در مزایده
                    </a>
                </div>

            </div>

        </div>



        {{-- تب منبع --}}

        <div class="mb-6 flex flex-wrap gap-2">
            <a href="{{ route('auctions.index', array_merge(request()->except(['source','page']))) }}"
               @class([
                   'rounded-full px-5 py-2 text-sm font-bold transition',
                   'bg-blue-600 text-white' => !request('source'),
                   'bg-white text-slate-600 border border-slate-200' => request('source'),
               ])>همه</a>

            @foreach($sources as $key => $label)
                <a href="{{ route('auctions.index', array_merge(request()->except('page'), ['source' => $key])) }}"
                   @class([
                       'rounded-full px-5 py-2 text-sm font-bold transition',
                       'bg-blue-600 text-white' => request('source') === $key,
                       'bg-white text-slate-600 border border-slate-200' => request('source') !== $key,
                   ])>{{ $label }}</a>
            @endforeach
        </div>



        {{-- فیلترها --}}

        <form method="GET" class="mb-8 flex flex-wrap items-end gap-3">

            @if(request('source'))
                <input type="hidden" name="source" value="{{ request('source') }}">
            @endif

            <div>
                <label class="block mb-1 text-sm font-semibold text-slate-600">نوع کار</label>
                <select name="scope" class="h-11 rounded-xl border border-slate-300 bg-white px-3">
                    <option value="">همه</option>
                    @foreach($scopes as $key => $label)
                        <option value="{{ $key }}" @selected(request('scope') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-slate-600">استان</label>
                <input type="text" name="province" value="{{ request('province') }}"
                       class="h-11 rounded-xl border border-slate-300 bg-white px-3" placeholder="مثلاً تهران">
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-slate-600">وضعیت</label>
                <select name="status" class="h-11 rounded-xl border border-slate-300 bg-white px-3">
                    <option value="">همه</option>
                    <option value="active" @selected(request('status') === 'active')>در حال برگزاری</option>
                    <option value="closed" @selected(request('status') === 'closed')>پایان مهلت</option>
                    <option value="awarded" @selected(request('status') === 'awarded')>واگذار شده</option>
                </select>
            </div>

            <button type="submit" class="h-11 rounded-xl bg-blue-600 px-6 font-bold text-white">
                اعمال فیلتر
            </button>

        </form>



        {{-- فهرست --}}

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            @forelse($auctions as $auction)

                <a href="{{ route('auction.show', $auction->slug) }}"
                   class="block rounded-2xl border border-slate-200 bg-white p-6 transition hover:border-blue-400 hover:shadow-lg">

                    <div class="mb-3 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                {{ $scopes[$auction->scope] ?? $auction->scope }}
                            </span>
                            @if($auction->isExternal())
                                <span class="rounded-full bg-sky-100 px-2 py-1 text-[11px] font-bold text-sky-700">ستاد</span>
                            @endif
                        </div>
                        <span class="text-xs font-bold
                            @class([
                                'text-green-600' => $auction->status === 'active',
                                'text-amber-600' => $auction->status === 'closed',
                                'text-blue-600'  => $auction->status === 'awarded',
                            ])">
                            {{ $auction->statusLabel() }}
                        </span>
                    </div>

                    <h2 class="mb-2 text-lg font-extrabold text-slate-800">{{ $auction->title }}</h2>

                    @if($auction->organization)
                        <p class="mb-1 text-sm text-slate-500">🏛️ {{ $auction->organization }}</p>
                    @endif

                    <p class="mb-4 text-sm text-slate-500">
                        📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}
                        @if($auction->tender_no)
                            &nbsp;·&nbsp; شماره: {{ $auction->tender_no }}
                        @endif
                    </p>

                    <div class="flex items-center justify-between border-t border-slate-100 pt-3 text-sm">
                        <span class="text-slate-500">{{ $auction->bids_count }} پیشنهاد</span>
                        <span class="font-bold text-slate-700">
                            @if($auction->leading_amount)
                                پیشرو: {{ number_format($auction->leading_amount) }} ت
                            @else
                                بدون پیشنهاد
                            @endif
                        </span>
                    </div>

                    @if($auction->status === 'active' && $auction->ends_at)
                        <p class="mt-3 text-xs text-slate-400">
                            پایان مهلت: {{ jdatetime($auction->ends_at) }}
                            ({{ jdiff($auction->ends_at) }})
                        </p>
                    @endif

                </a>

            @empty

                <div class="col-span-full rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500">
                    فعلاً مزایده‌ای ثبت نشده است.
                </div>

            @endforelse

        </div>


        <div class="mt-8">
            {{ $auctions->links() }}
        </div>


    </div>

</main>



@include('sections.footer')


@endsection
