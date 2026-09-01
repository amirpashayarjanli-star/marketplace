@extends('dashboard.layouts.dashboard')


@section('content')


<div class="auction-back">
    <a href="{{ route('dashboard.auctions') }}">← مزایده‌های من</a>
</div>


@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- مرحله‌ی مشاوره — تا کامل نشود، مزایده منتشر نمی‌شود --}}

@if($auction->source === 'onsite' && ! in_array($auction->status, ['cancelled', 'awarded']) && ! $auction->readyToPublish())

    <section class="consult-panel">

        <header class="consult-panel-head">

            <span class="consult-panel-icon">☎️</span>

            <div>
                <h2>مرحله‌ی مشاوره‌ی تخصصی</h2>
                <p>پیش از انتشار مزایده، کارشناسان ما پروژه‌ی شما را بررسی می‌کنند.</p>
            </div>

        </header>

        <ul class="consult-benefits">
            <li>بررسی مشخصات فنی و برآورد واقعی هزینه</li>
            <li>تنظیم درست شرح پروژه تا شرکت‌های معتبر پیشنهاد بدهند</li>
            <li>راهنمایی برای انتخاب بهترین پیشنهاد از میان رقبا</li>
        </ul>


        {{-- گام ۱: تماس --}}

        <div class="consult-step">

            <div class="consult-step-head">
                <span class="badge badge-gold">گام ۱</span>
                <span class="consult-step-title">تماس با کارشناس</span>
                @if($auction->consulted_at)
                    <span class="badge badge-success">انجام شد</span>
                @endif
            </div>

            @unless($auction->consulted_at)

                <p class="consult-step-desc">
                    با شماره‌ی زیر تماس بگیرید یا درخواست تماس ثبت کنید تا ما تماس بگیریم.
                </p>

                <div class="consult-step-actions">

                    <a href="tel:{{ $consultationPhone }}" class="btn auction-cta-phone">
                        📞 {{ $consultationPhone }}
                    </a>

                    @if($auction->callback_requested_at)
                        <span class="consult-step-desc">
                            درخواست تماس ثبت شد ({{ jdatetime($auction->callback_requested_at) }})
                        </span>
                    @else
                        <form method="POST" action="{{ route('dashboard.auctions.callback', $auction) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline">شما با من تماس بگیرید</button>
                        </form>
                    @endif

                </div>

            @endunless

        </div>


        {{-- گام ۲: پرداخت هزینه‌ی مشاوره --}}

        @if((int) $auction->consultation_fee > 0)

            <div class="consult-step">

                <div class="consult-step-head">
                    <span class="badge badge-gold">گام ۲</span>
                    <span class="consult-step-title">پرداخت هزینه‌ی مشاوره</span>
                    @if($auction->consultationPaid())
                        <span class="badge badge-success">پرداخت شد</span>
                    @endif
                </div>

                @unless($auction->consultationPaid())

                    <p class="consult-step-desc">
                        مبلغ <strong>{{ number_format($auction->consultation_fee) }} تومان</strong>
                        از کیف‌پول شما کسر می‌شود. پس از پرداخت، مزایده منتشر می‌شود.
                    </p>

                    <div class="consult-step-actions">

                        <form method="POST" action="{{ route('dashboard.auctions.pay-consultation', $auction) }}"
                              onsubmit="return confirm('مبلغ {{ number_format($auction->consultation_fee) }} تومان از کیف‌پول کسر شود؟')">
                            @csrf
                            <button type="submit" class="btn btn-success">پرداخت از کیف‌پول</button>
                        </form>

                        <a href="{{ route('wallet') }}" class="btn btn-outline">شارژ کیف‌پول</a>

                    </div>

                @endunless

            </div>

        @endif

    </section>

@elseif($auction->source === 'onsite' && $auction->consulted_at && $auction->status === 'pending_review')

    <div class="alert alert-success">
        <strong>✅ مشاوره کامل شد — مزایده در انتظار تایید نهایی مدیر است.</strong>
        <span>به‌محض تایید، به فهرست عمومی مزایده‌ها می‌رود و به شرکت‌ها پیامک اطلاع‌رسانی می‌شود.</span>
    </div>

@endif


<div class="card auction-detail-card">

    <div class="auction-detail-card-head">
        <h1>{{ $auction->title }}</h1>
        <span class="badge">{{ $auction->statusLabel() }}</span>
    </div>

    <p class="auction-card-meta">
        {{ \App\Models\Auction::SCOPES[$auction->scope] ?? $auction->scope }}
        &nbsp;·&nbsp;
        📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}
    </p>

    <p class="auction-card-meta">
        @if($auction->ends_at)
            پایان مهلت: {{ jdatetime($auction->ends_at) }} ({{ jdiff($auction->ends_at) }})
            &nbsp;·&nbsp;
        @endif
        کارمزد هر پیشنهاد: {{ rtrim(rtrim(number_format($auction->fee_percent, 2), '0'), '.') }}٪
    </p>

    <p class="auction-description">{{ $auction->description }}</p>

    @if(! in_array($auction->status, ['awarded', 'cancelled']))

        <form method="POST" action="{{ route('dashboard.auctions.cancel', $auction) }}"
              class="auction-cancel-form"
              onsubmit="return confirm('مزایده لغو شود؟ کارمزد همه‌ی پیشنهادها برگشت داده می‌شود.')">
            @csrf

            <input type="text" name="reason" class="input" placeholder="دلیل لغو (اختیاری)">

            <button type="submit" class="btn btn-danger-outline">لغو مزایده</button>

        </form>

    @endif

</div>


<h2 class="auction-bids-title">
    پیشنهادها ({{ $auction->bids->whereIn('status', ['active','won','lost'])->count() }})
</h2>

<div class="auction-table-wrap">

    <table class="auction-table">

        <thead>
            <tr>
                <th>پیشنهاددهنده</th>
                <th>مبلغ (تومان)</th>
                <th>زمان تحویل</th>
                <th>توضیح</th>
                <th>اقدام</th>
            </tr>
        </thead>

        <tbody>

            @php
                $leadingId = optional(
                    $auction->bids->where('status', 'active')->sortBy('amount')->first()
                )->id;
            @endphp

            @forelse($auction->bids->whereIn('status', ['active','won','lost'])->sortBy('amount') as $bid)

                <tr @class(['is-leading' => $bid->id === $leadingId])>

                    <td class="auction-bidder">
                        {{ $bid->user->company->name
                            ?? $bid->user->manufacturer->name
                            ?? $bid->user->technician->name
                            ?? $bid->user->name }}

                        @if($bid->id === $leadingId)
                            <span class="auction-flag auction-flag-lead">پیشرو</span>
                        @endif

                        @if($bid->status === 'won')
                            <span class="auction-flag auction-flag-won">برنده</span>
                        @endif
                    </td>

                    <td class="auction-amount">{{ number_format($bid->amount) }}</td>

                    <td>{{ $bid->delivery_days ? $bid->delivery_days.' روز' : '—' }}</td>

                    <td>{{ $bid->description ?: '—' }}</td>

                    <td>
                        @if($bid->status === 'active' && in_array($auction->status, ['active','closed']))
                            <form method="POST" action="{{ route('dashboard.auctions.award', $auction) }}"
                                  onsubmit="return confirm('این پیشنهاد به‌عنوان برنده انتخاب شود؟')">
                                @csrf
                                <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                                <button type="submit" class="btn btn-sm btn-success">اعلام برنده</button>
                            </form>
                        @else
                            —
                        @endif
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="auction-empty-row">هنوز پیشنهادی ثبت نشده است.</td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


@endsection
