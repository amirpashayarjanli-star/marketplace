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

        @php $consultFee = (int) config('proauction.consultation_fee', 0); @endphp

        <div class="auction-cta">

            <div class="auction-cta-text">

                <h2>
                    پروژه‌ی آسانسور دارید؟
                    {{ $consultFee > 0 ? 'مشاوره‌ی تخصصی بگیرید' : 'رایگان مشاوره بگیرید' }}
                </h2>

                <p>
                    کارشناسان آسانسور پرو پروژه‌ی شما را بررسی می‌کنند، برآورد واقعی هزینه می‌دهند
                    و مزایده‌تان را طوری تنظیم می‌کنند که شرکت‌های معتبر رقابت کنند —
                    نه اینکه فقط ارزان‌ترین بیاید.
                </p>

                <div class="auction-cta-tags">
                    <span class="badge">برآورد کارشناسی هزینه</span>
                    <span class="badge">تنظیم شرح فنی</span>
                    <span class="badge">راهنمایی انتخاب برنده</span>
                    @if($consultFee > 0)
                        <span class="badge badge-gold">
                            هزینه: {{ number_format($consultFee) }} تومان
                        </span>
                    @endif
                </div>

            </div>

            <div class="auction-cta-actions">

                <a href="tel:{{ config('proauction.consultation_phone') }}"
                   class="btn btn-lg auction-cta-phone">
                    📞 {{ config('proauction.consultation_phone') }}
                </a>

                <a href="{{ route('dashboard.auctions.create') }}" class="btn btn-outline">
                    ثبت پروژه در مزایده
                </a>

            </div>

        </div>



        {{-- تب منبع --}}

        <div class="auction-tabs">

            <a href="{{ route('auctions.index', request()->except(['source','page'])) }}"
               @class(['auction-tab', 'is-active' => ! request('source')])>همه</a>

            @foreach($sources as $key => $label)
                <a href="{{ route('auctions.index', array_merge(request()->except('page'), ['source' => $key])) }}"
                   @class(['auction-tab', 'is-active' => request('source') === $key])>{{ $label }}</a>
            @endforeach

        </div>



        {{-- فیلترها --}}

        <form method="GET" class="auction-filter">

            @if(request('source'))
                <input type="hidden" name="source" value="{{ request('source') }}">
            @endif

            <div class="field">
                <label class="field-label" for="filter-scope">نوع کار</label>
                <select id="filter-scope" name="scope" class="input">
                    <option value="">همه</option>
                    @foreach($scopes as $key => $label)
                        <option value="{{ $key }}" @selected(request('scope') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="field-label" for="filter-province">استان</label>
                <input id="filter-province" type="text" name="province" class="input"
                       value="{{ request('province') }}" placeholder="مثلاً تهران">
            </div>

            <div class="field">
                <label class="field-label" for="filter-status">وضعیت</label>
                <select id="filter-status" name="status" class="input">
                    <option value="">همه</option>
                    <option value="active" @selected(request('status') === 'active')>در حال برگزاری</option>
                    <option value="closed" @selected(request('status') === 'closed')>پایان مهلت</option>
                    <option value="awarded" @selected(request('status') === 'awarded')>واگذار شده</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">اعمال فیلتر</button>

        </form>



        {{-- فهرست --}}

        <div class="auction-grid">

            @forelse($auctions as $auction)

                <a href="{{ route('auction.show', $auction->slug) }}" class="card auction-card">

                    <div class="auction-card-head">

                        <div class="auction-card-tags">
                            <span class="badge">{{ $scopes[$auction->scope] ?? $auction->scope }}</span>
                            @if($auction->isExternal())
                                <span class="badge badge-gold">ستاد</span>
                            @endif
                        </div>

                        <span class="auction-status auction-status-{{ $auction->status }}">
                            {{ $auction->statusLabel() }}
                        </span>

                    </div>

                    <h2 class="auction-card-title">{{ $auction->title }}</h2>

                    @if($auction->organization)
                        <p class="auction-card-meta">🏛️ {{ $auction->organization }}</p>
                    @endif

                    <p class="auction-card-meta">
                        📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}
                        @if($auction->tender_no)
                            &nbsp;·&nbsp; شماره: {{ $auction->tender_no }}
                        @endif
                    </p>

                    <div class="auction-card-foot">
                        <span>{{ $auction->bids_count }} پیشنهاد</span>
                        <span class="auction-lead">
                            @if($auction->leading_amount)
                                پیشرو: {{ number_format($auction->leading_amount) }} ت
                            @else
                                بدون پیشنهاد
                            @endif
                        </span>
                    </div>

                    @if($auction->status === 'active' && $auction->ends_at)
                        <p class="auction-deadline">
                            پایان مهلت: {{ jdatetime($auction->ends_at) }}
                            ({{ jdiff($auction->ends_at) }})
                        </p>
                    @endif

                </a>

            @empty

                <div class="auction-board-empty" style="grid-column:1 / -1;">
                    <p>فعلاً مزایده‌ای ثبت نشده است.</p>
                </div>

            @endforelse

        </div>


        {{ $auctions->links() }}


    </div>

</main>



@include('sections.footer')


@endsection
