@extends('layouts.app')


@section('title', $auction->title . ' — پرو مزایده')


@section('content')


@include('sections.header-inner')



<main class="directory-page">

    <div class="container-app">


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



        <div class="auction-detail">


            {{-- ستون اصلی --}}

            <div class="auction-detail-main">

                <div class="auction-detail-head">
                    <span class="badge">
                        {{ \App\Models\Auction::SCOPES[$auction->scope] ?? $auction->scope }}
                    </span>
                    <span class="auction-status auction-status-{{ $auction->status }}">
                        {{ $auction->statusLabel() }}
                    </span>
                </div>

                <h1>{{ $auction->title }}</h1>

                <p class="auction-card-meta">
                    📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}
                    @if($auction->employer)
                        &nbsp;·&nbsp; کارفرما: {{ $auction->employer->name }}
                    @endif
                </p>


                @if($auction->isExternal())

                    <div class="auction-external">

                        <div class="auction-external-head">
                            <span class="badge badge-gold">سامانه ستاد</span>
                            این مناقصه از سامانه‌ی تدارکات الکترونیکی دولت بازنشر شده است.
                        </div>

                        <dl>
                            @if($auction->organization)
                                <div><dt>دستگاه مناقصه‌گزار:</dt> <dd>{{ $auction->organization }}</dd></div>
                            @endif
                            @if($auction->tender_no)
                                <div><dt>شماره فراخوان:</dt> <dd>{{ $auction->tender_no }}</dd></div>
                            @endif
                            @if($auction->category)
                                <div><dt>طبقه‌بندی:</dt> <dd>{{ $auction->category }}</dd></div>
                            @endif
                            @if($auction->published_at)
                                <div><dt>تاریخ انتشار:</dt> <dd>{{ jdate($auction->published_at) }}</dd></div>
                            @endif
                        </dl>

                        @if($auction->source_url)
                            <a href="{{ $auction->source_url }}" target="_blank" rel="noopener"
                               class="btn btn-sm btn-primary" style="margin-top:14px;">
                                مشاهده و شرکت در سامانه ستاد ↗
                            </a>
                        @endif

                    </div>

                @endif


                <div class="auction-description">{{ $auction->description }}</div>


                @if($auction->specs && ! empty($auction->specs['note']))
                    <div class="auction-specs">
                        <strong>مشخصات فنی:</strong>{{ $auction->specs['note'] }}
                    </div>
                @endif



                {{-- جدول پیشنهادها --}}

                <h2 class="auction-bids-title">
                    پیشنهادها ({{ $auction->bids->where('status', '!=', 'withdrawn')->count() }})
                </h2>

                <div class="auction-table-wrap">

                    <table class="auction-table">

                        <thead>
                            <tr>
                                <th>پیشنهاددهنده</th>
                                <th>مبلغ (تومان)</th>
                                <th>زمان تحویل</th>
                                <th>ثبت</th>
                            </tr>
                        </thead>

                        <tbody>

                            @php
                                $leadingId = optional(
                                    $auction->bids->where('status', 'active')->sortBy('amount')->first()
                                )->id;
                            @endphp

                            @forelse($auction->bids->whereIn('status', ['active','won','lost']) as $bid)

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

                                        @auth
                                            @if($bid->user_id === auth()->id())
                                                <span class="auction-flag auction-flag-mine">شما</span>
                                            @endif
                                        @endauth
                                    </td>

                                    <td class="auction-amount">{{ number_format($bid->amount) }}</td>

                                    <td>{{ $bid->delivery_days ? $bid->delivery_days.' روز' : '—' }}</td>

                                    <td>{{ jdate($bid->created_at) }}</td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="auction-empty-row">هنوز پیشنهادی ثبت نشده است.</td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>



            {{-- ستون کناری — پنل اقدام --}}

            <aside>

                <div class="auction-panel">

                    <dl class="auction-summary">

                        <div class="auction-summary-row">
                            <dt>وضعیت</dt>
                            <dd>{{ $auction->statusLabel() }}</dd>
                        </div>

                        @if($auction->ends_at)
                            <div class="auction-summary-row">
                                <dt>پایان مهلت</dt>
                                <dd>{{ jdatetime($auction->ends_at) }}</dd>
                            </div>
                        @endif

                        <div class="auction-summary-row">
                            <dt>مجاز به پیشنهاد</dt>
                            <dd>{{ $auction->allowedBiddersLabel() }}</dd>
                        </div>

                        @if($auction->budget_max)
                            <div class="auction-summary-row">
                                <dt>سقف بودجه</dt>
                                <dd>{{ number_format($auction->budget_max) }} ت</dd>
                            </div>
                        @endif

                        <div class="auction-summary-row">
                            <dt>کارمزد هر پیشنهاد</dt>
                            <dd>{{ rtrim(rtrim(number_format($auction->fee_percent, 2), '0'), '.') }}٪</dd>
                        </div>

                    </dl>


                    @guest

                        <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                            برای ثبت پیشنهاد وارد شوید
                        </a>

                    @else

                        @if($myBid)

                            <div class="auction-mybid">
                                <p class="auction-mybid-label">پیشنهاد فعلی شما</p>
                                <p class="auction-mybid-amount">{{ number_format($myBid->amount) }} تومان</p>
                                @if($myBid->delivery_days)
                                    <p class="auction-mybid-meta">تحویل: {{ $myBid->delivery_days }} روز</p>
                                @endif
                            </div>

                            @if($auction->isOpen() && $myBid->status === 'active')

                                <form method="POST" action="{{ route('dashboard.bids.update', $myBid) }}"
                                      class="auction-form">
                                    @csrf
                                    @method('PUT')

                                    <div class="field">
                                        <label class="field-label" for="bid-amount">مبلغ جدید (فقط کاهش)</label>
                                        <input id="bid-amount" type="number" name="amount" class="input"
                                               required max="{{ $myBid->amount }}"
                                               value="{{ old('amount', $myBid->amount) }}">
                                    </div>

                                    <div class="field">
                                        <label class="field-label" for="bid-days">زمان تحویل (روز)</label>
                                        <input id="bid-days" type="number" name="delivery_days" class="input"
                                               value="{{ old('delivery_days', $myBid->delivery_days) }}">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        به‌روزرسانی پیشنهاد
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('dashboard.bids.withdraw', $myBid) }}"
                                      style="margin-top:10px;"
                                      onsubmit="return confirm('از پیشنهاد انصراف می‌دهید؟ کارمزد به کیف‌پول برمی‌گردد.')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-block btn-danger-outline">
                                        انصراف از پیشنهاد
                                    </button>
                                </form>

                            @endif

                        @elseif($canBid)

                            <form method="POST" action="{{ route('auction.bids.store', $auction) }}"
                                  class="auction-form">
                                @csrf

                                <div class="field">
                                    <label class="field-label" for="new-amount">مبلغ پیشنهادی (تومان)</label>
                                    <input id="new-amount" type="number" name="amount" class="input"
                                           required min="1" value="{{ old('amount') }}"
                                           @if($auction->budget_max) max="{{ $auction->budget_max }}" @endif>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="new-days">زمان تحویل (روز)</label>
                                    <input id="new-days" type="number" name="delivery_days" class="input"
                                           value="{{ old('delivery_days') }}">
                                </div>

                                <div class="field">
                                    <label class="field-label" for="new-desc">توضیح (اختیاری)</label>
                                    <textarea id="new-desc" name="description" rows="3"
                                              class="input">{{ old('description') }}</textarea>
                                </div>

                                <p class="auction-note">
                                    هنگام ثبت، کارمزد
                                    {{ rtrim(rtrim(number_format($auction->fee_percent, 2), '0'), '.') }}٪
                                    مبلغ پیشنهاد از کیف‌پول شما کسر می‌شود. با انصراف یا لغو مزایده، برمی‌گردد.
                                </p>

                                <button type="submit" class="btn btn-block btn-success">
                                    ثبت پیشنهاد
                                </button>
                            </form>

                        @else

                            <p class="auction-blocked">
                                @if(! $auction->bids_enabled)
                                    ثبت پیشنهاد روی سایت برای این مناقصه فعال نیست.
                                    @if($auction->source_url) از طریق دکمه‌ی سامانه ستاد اقدام کنید. @endif
                                @elseif(! $auction->isOpen())
                                    مهلت این مزایده به پایان رسیده است.
                                @else
                                    برای این نوع کار فقط {{ $auction->allowedBiddersLabel() }}
                                    (تاییدشده) می‌توانند پیشنهاد بدهند.
                                @endif
                            </p>

                        @endif

                    @endguest

                </div>

            </aside>


        </div>


    </div>

</main>



@include('sections.footer')


@endsection
