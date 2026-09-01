@extends('layouts.app')

@section('title', $building->title . ' | پرونده')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        @include('admin.partials.nav')


        <div class="service-page-head">

            <div>
                <span class="building-code">{{ $building->code }}</span>
                <h1 class="wizard-title">{{ $building->title }}</h1>
                <p class="wizard-subtitle">📍 {{ $building->fullAddress() ?: '—' }}</p>
            </div>

            <div class="service-page-head-actions">
                <a href="{{ route('admin.buildings.create') }}" class="btn btn-sm btn-outline">
                    پرونده‌ی جدید
                </a>
            </div>

        </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif



        {{-- ---- مشتری ---- --}}

        <section class="card contract-summary">

            <div class="contract-summary-head">
                <div>
                    <span class="badge">مشتری</span>
                    <h2>{{ $building->customer->name }}</h2>
                </div>
            </div>

            <dl class="contract-facts">

                <div>
                    <dt>موبایل</dt>
                    <dd>{{ $building->customer->mobile ?? '—' }}</dd>
                </div>

                <div>
                    <dt>تلفن ثابت</dt>
                    <dd>{{ $building->customer->phone ?? '—' }}</dd>
                </div>

                <div>
                    <dt>مدیر ساختمان</dt>
                    <dd>
                        {{ $building->manager_name ?? '—' }}
                        @if($building->manager_mobile)
                            — {{ $building->manager_mobile }}
                        @endif
                    </dd>
                </div>

                <div>
                    <dt>ساختمان</dt>
                    <dd>
                        {{ $building->floors ? $building->floors . ' طبقه' : '—' }}
                        @if($building->units)
                            · {{ $building->units }} واحد
                        @endif
                    </dd>
                </div>

            </dl>

        </section>



        {{-- ---- قرارداد ---- --}}

        @if($activeContract)

            <section class="card contract-summary">

                <div class="contract-summary-head">
                    <div>
                        <span class="badge badge-success">قرارداد فعال</span>
                        <h2>{{ $activeContract->planLabel() }} — {{ $activeContract->termLabel() }}</h2>
                    </div>
                    <a href="{{ route('admin.contracts.show', $activeContract) }}" class="btn btn-sm btn-outline">
                        مدیریت قرارداد
                    </a>
                </div>

                <dl class="contract-facts">

                    <div>
                        <dt>شماره قرارداد</dt>
                        <dd>{{ $activeContract->code }}</dd>
                    </div>

                    <div>
                        <dt>اعتبار تا</dt>
                        <dd>
                            {{ jdate($activeContract->ends_at) }}
                            @if($activeContract->daysLeft() !== null)
                                <small>({{ $activeContract->daysLeft() }} روز)</small>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt>تکنسین</dt>
                        <dd>{{ $activeContract->technician?->name ?? $activeContract->technicianModeLabel() }}</dd>
                    </div>

                    <div>
                        <dt>بیمه</dt>
                        <dd>
                            @if($activeContract->activePolicy)
                                {{ $activeContract->activePolicy->insurer }}
                                — تا {{ jdate($activeContract->activePolicy->ends_at) }}
                            @else
                                هنوز صادر نشده
                            @endif
                        </dd>
                    </div>

                </dl>

            </section>

        @else

            <section class="card contract-cta">

                <div>
                    <h2>این پرونده قرارداد فعال ندارد</h2>
                    <p>
                        قرارداد را ثبت کنید تا در فهرست قراردادها قیمت نهایی را بگذارید و
                        برای پرداخت به مشتری برود.
                    </p>
                </div>

                <a href="{{ route('admin.buildings.contract', $building) }}" class="btn btn-primary">
                    ثبت قرارداد سرویس
                </a>

            </section>

        @endif



        {{-- ---- دستگاه‌ها ---- --}}

        <section class="building-block">

            <h2 class="building-block-title">دستگاه‌های آسانسور ({{ $building->elevators->count() }})</h2>

            <div class="elevator-list">

                @foreach($building->elevators as $elevator)

                    <div class="card elevator-item">

                        <div>
                            <strong>{{ $elevator->label }}</strong>
                            <p class="building-card-meta">{{ $elevator->summary() }}</p>
                            @if($elevator->serial_no)
                                <p class="building-card-meta">سریال: {{ $elevator->serial_no }}</p>
                            @endif
                        </div>

                    </div>

                @endforeach

            </div>

        </section>



        {{-- ---- خرابی‌ها ---- --}}

        <section class="building-block">

            <h2 class="building-block-title">خرابی‌های این ساختمان</h2>

            <div class="service-list">

                @forelse($building->serviceRequests as $request)

                    <a href="{{ route('admin.service.show', $request) }}" class="service-card">

                        <div class="service-card-head">
                            <span class="service-card-title">خرابی #{{ $request->id }}</span>
                            <span class="service-status service-status-{{ $request->status }}">
                                {{ $request->label() }}
                            </span>
                        </div>

                        <p class="service-card-desc">
                            {{ \Illuminate\Support\Str::limit($request->description, 110) }}
                        </p>

                        <div class="service-card-meta">
                            {{ jdatetime($request->created_at) }}
                            @if($request->technician)
                                · تکنسین: {{ $request->technician->name }}
                            @endif
                        </div>

                    </a>

                @empty

                    <p class="auction-blocked">برای این ساختمان خرابی‌ای ثبت نشده است.</p>

                @endforelse

            </div>

        </section>



        {{-- ---- همه‌ی قراردادها ---- --}}

        @if($building->contracts->count() > ($activeContract ? 1 : 0))

            <section class="building-block">

                <h2 class="building-block-title">قراردادها</h2>

                <div class="service-list">

                    @foreach($building->contracts as $contract)

                        <a href="{{ route('admin.contracts.show', $contract) }}" class="service-card">

                            <div class="service-card-head">
                                <span class="service-card-title">
                                    {{ $contract->code }} — {{ $contract->planLabel() }}
                                </span>
                                <span class="badge @if($contract->isActive()) badge-success @elseif($contract->status === 'cancelled') badge-danger @endif">
                                    {{ $contract->statusLabel() }}
                                </span>
                            </div>

                            <div class="service-card-meta">
                                {{ $contract->termLabel() }}
                                @if($contract->starts_at)
                                    · {{ jdate($contract->starts_at) }} تا {{ jdate($contract->ends_at) }}
                                @endif
                                · {{ number_format($contract->total_amount) }} تومان
                            </div>

                        </a>

                    @endforeach

                </div>

            </section>

        @endif


    </div>

</div>

@endsection
