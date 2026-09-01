@extends('layouts.app')

@section('title', 'قرارداد ' . $contract->code)

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="service-page-head">

            <div>
                <span class="building-code">{{ $contract->code }}</span>
                <h1 class="wizard-title">{{ $contract->planLabel() }} — {{ $contract->termLabel() }}</h1>
                <p class="wizard-subtitle">
                    پرونده:
                    <a href="{{ route('service.buildings.show', $contract->building) }}">
                        {{ $contract->building->title }}
                    </a>
                </p>
            </div>

            <span class="badge @if($contract->isActive()) badge-success @elseif($contract->status === 'cancelled') badge-danger @elseif($contract->status === 'awaiting_payment') badge-warning @endif">
                {{ $contract->statusLabel() }}
            </span>

        </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif



        {{-- ---- وضعیت و اقدام ---- --}}

        @if($contract->status === 'pending_review')

            <div class="alert">
                <strong>در انتظار بررسی</strong>
                <span>
                    کارشناسان ما پرونده و تعداد دستگاه‌ها را بررسی می‌کنند و قیمت نهایی را
                    اعلام می‌کنند. بعد از آن دکمه‌ی پرداخت همین‌جا فعال می‌شود.
                </span>
            </div>

        @elseif($contract->status === 'awaiting_payment')

            <div class="card contract-pay">

                <div>
                    <p class="contract-total-label">مبلغ قابل پرداخت</p>
                    <p class="contract-total-amount">{{ number_format($contract->total_amount) }} تومان</p>
                    <p class="field-hint">
                        موجودی کیف‌پول شما: {{ number_format($balance) }} تومان
                    </p>
                    @if($contract->admin_note)
                        <p class="field-hint">یادداشت کارشناس: {{ $contract->admin_note }}</p>
                    @endif
                </div>

                <div class="contract-pay-actions">

                    @if($balance >= $contract->total_amount)
                        <form method="POST" action="{{ route('service.contracts.pay', $contract) }}"
                              onsubmit="return confirm('مبلغ {{ number_format($contract->total_amount) }} تومان از کیف‌پول کسر شود؟')">
                            @csrf
                            <button type="submit" class="btn btn-success">پرداخت از کیف‌پول</button>
                        </form>
                    @else
                        <p class="auction-note">
                            موجودی کیف‌پول کافی نیست؛
                            {{ number_format($contract->total_amount - $balance) }} تومان کم دارید.
                        </p>
                    @endif

                    <a href="{{ route('wallet') }}" class="btn btn-outline">شارژ کیف‌پول</a>

                </div>

            </div>

        @endif



        {{-- ---- مشخصات قرارداد ---- --}}

        <section class="card contract-detail">

            <h2 class="building-block-title">مشخصات قرارداد</h2>

            <dl class="contract-facts">

                <div>
                    <dt>طرح</dt>
                    <dd>{{ $contract->planLabel() }}</dd>
                </div>

                <div>
                    <dt>مدت</dt>
                    <dd>{{ $contract->termLabel() }} ({{ $contract->months }} ماه)</dd>
                </div>

                <div>
                    <dt>تعداد دستگاه</dt>
                    <dd>{{ $contract->elevator_count }}</dd>
                </div>

                <div>
                    <dt>اجاره‌ی ماهانه هر دستگاه</dt>
                    <dd>{{ number_format($contract->monthly_fee) }} تومان</dd>
                </div>

                @if($contract->discount_percent > 0)
                    <div>
                        <dt>تخفیف دوره</dt>
                        <dd>{{ $contract->discount_percent }}٪</dd>
                    </div>
                @endif

                <div>
                    <dt>مبلغ کل</dt>
                    <dd>{{ number_format($contract->total_amount) }} تومان</dd>
                </div>

                <div>
                    <dt>تکنسین</dt>
                    <dd>{{ $contract->technician?->name ?? $contract->technicianModeLabel() }}</dd>
                </div>

                @if($contract->starts_at)
                    <div>
                        <dt>بازه</dt>
                        <dd>{{ jdate($contract->starts_at) }} تا {{ jdate($contract->ends_at) }}</dd>
                    </div>
                @endif

            </dl>

        </section>



        {{-- ---- بیمه ---- --}}

        <section class="building-block">

            <h2 class="building-block-title">بیمه‌نامه</h2>

            @forelse($contract->policies as $policy)

                <div class="card policy-card @if($policy->isValid()) is-valid @endif">

                    <div>
                        <strong>{{ $policy->insurer }}</strong>
                        <p class="building-card-meta">شماره بیمه‌نامه: {{ $policy->policy_no }}</p>
                        <p class="building-card-meta">
                            سقف پوشش: {{ number_format($policy->coverage_amount) }} تومان
                        </p>
                        <p class="building-card-meta">
                            {{ jdate($policy->starts_at) }} تا {{ jdate($policy->ends_at) }}
                        </p>
                    </div>

                    <div class="policy-card-side">
                        @if($policy->isValid())
                            <span class="badge badge-success">معتبر</span>
                        @else
                            <span class="badge">منقضی</span>
                        @endif

                        @if($policy->isExpiringSoon())
                            <span class="badge badge-warning">نزدیک به انقضا</span>
                        @endif
                    </div>

                </div>

            @empty

                <p class="auction-blocked">
                    @if($contract->isActive())
                        بیمه‌نامه در حال صدور است. به‌محض صدور، مشخصاتش همین‌جا ثبت می‌شود.
                    @else
                        بیمه‌نامه پس از فعال‌شدن قرارداد صادر می‌شود.
                    @endif
                </p>

            @endforelse

        </section>



        {{-- ---- بازدیدهای دوره‌ای ---- --}}

        @if($contract->isPeriodic())

            <section class="building-block">

                <h2 class="building-block-title">برنامه‌ی سرویس دوره‌ای</h2>

                @forelse($contract->visits as $visit)

                    <div class="card visit-item @if($visit->isOverdue()) is-overdue @endif">

                        <div>
                            <strong>{{ jdate($visit->due_on) }}</strong>
                            <p class="building-card-meta">
                                {{ $visit->technician?->name ?? 'تکنسین هنوز مشخص نشده' }}
                            </p>
                            @if($visit->report)
                                <p class="building-card-meta">{{ $visit->report }}</p>
                            @endif
                        </div>

                        <span @class([
                            'badge',
                            'badge-success' => $visit->status === 'done',
                            'badge-danger'  => $visit->status === 'missed',
                            'badge-warning' => $visit->isOverdue(),
                        ])>{{ $visit->statusLabel() }}</span>

                    </div>

                @empty

                    <p class="auction-blocked">
                        برنامه‌ی بازدیدها بعد از فعال‌شدن قرارداد ساخته می‌شود.
                    </p>

                @endforelse

            </section>

        @endif



        {{-- ---- لغو ---- --}}

        @if(! in_array($contract->status, ['cancelled', 'expired'], true))

            <form method="POST" action="{{ route('service.contracts.cancel', $contract) }}"
                  class="auction-cancel-form"
                  onsubmit="return confirm('قرارداد لغو شود؟ برای تسویه‌ی باقی‌مانده‌ی دوره باید با پشتیبانی تماس بگیرید.')">
                @csrf

                <input type="text" name="reason" class="input" placeholder="دلیل لغو (اختیاری)">

                <button type="submit" class="btn btn-danger-outline">لغو قرارداد</button>

            </form>

        @elseif($contract->cancel_reason)

            <p class="auction-blocked">دلیل لغو: {{ $contract->cancel_reason }}</p>

        @endif


    </div>

</div>

@endsection
