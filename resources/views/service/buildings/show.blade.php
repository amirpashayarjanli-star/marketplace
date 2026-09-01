@extends('layouts.app')

@section('title', $building->title . ' | پرونده')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="service-page-head">

            <div>
                <span class="building-code">{{ $building->code }}</span>
                <h1 class="wizard-title">{{ $building->title }}</h1>
                <p class="wizard-subtitle">📍 {{ $building->fullAddress() ?: '—' }}</p>
            </div>

            <div class="service-page-head-actions">
                <a href="{{ route('service.buildings.edit', $building) }}" class="btn btn-sm btn-outline">
                    ویرایش پرونده
                </a>
                <a href="{{ route('service.buildings') }}" class="btn btn-sm btn-ghost">
                    همه‌ی پرونده‌ها
                </a>
            </div>

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



        {{-- ---- قرارداد ---- --}}

        @if($activeContract)

            <section class="card contract-summary">

                <div class="contract-summary-head">
                    <div>
                        <span class="badge badge-success">قرارداد فعال</span>
                        <h2>{{ $activeContract->planLabel() }} — {{ $activeContract->termLabel() }}</h2>
                    </div>
                    <a href="{{ route('service.contracts.show', $activeContract) }}" class="btn btn-sm btn-outline">
                        جزئیات قرارداد
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
                        <dd>
                            {{ $activeContract->technician?->name ?? $activeContract->technicianModeLabel() }}
                        </dd>
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
                    <h2>این پرونده قرارداد سرویس ندارد</h2>
                    <p>
                        با بستن قرارداد، آسانسور شما بیمه می‌شود، تکنسین مشخص می‌گیرد و
                        بسته به طرح، سرویس دوره‌ای هم انجام می‌شود.
                    </p>
                </div>

                <a href="{{ route('service.contracts.create', $building) }}" class="btn btn-primary">
                    بستن قرارداد سرویس
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

                        @if($building->elevators->count() > 1)
                            <form method="POST"
                                  action="{{ route('service.buildings.elevators.destroy', [$building, $elevator->id]) }}"
                                  onsubmit="return confirm('این دستگاه از پرونده حذف شود؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger-outline">حذف</button>
                            </form>
                        @endif

                    </div>

                @endforeach

            </div>


            <details class="elevator-add">

                <summary>افزودن دستگاه</summary>

                <form method="POST" action="{{ route('service.buildings.elevators.store', $building) }}"
                      class="elevator-row">
                    @csrf

                    <div class="field">
                        <label class="field-label">نام دستگاه</label>
                        <input type="text" name="label" class="input" required>
                    </div>

                    <div class="field">
                        <label class="field-label">برند</label>
                        <input type="text" name="brand" class="input">
                    </div>

                    <div class="field">
                        <label class="field-label">ظرفیت (kg)</label>
                        <input type="number" name="capacity_kg" class="input" min="0">
                    </div>

                    <div class="field">
                        <label class="field-label">توقف</label>
                        <input type="number" name="stops" class="input" min="0">
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">افزودن</button>

                </form>

            </details>

        </section>



        {{-- ---- تاریخچه‌ی خرابی‌ها ---- --}}

        <section class="building-block">

            <div class="service-page-head">
                <h2 class="building-block-title">تاریخچه‌ی خرابی‌ها</h2>
                <a href="{{ route('service.create', ['building' => $building->id]) }}"
                   class="btn btn-sm btn-primary">
                    ثبت خرابی جدید
                </a>
            </div>

            <div class="service-list">

                @forelse($building->serviceRequests as $request)

                    <a href="{{ route('service.show', $request) }}" class="service-card">

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
                            @if($request->covered_by_contract)
                                · <span class="contract-covered">تحت پوشش قرارداد</span>
                            @endif
                        </div>

                    </a>

                @empty

                    <p class="auction-blocked">برای این ساختمان خرابی‌ای ثبت نشده است.</p>

                @endforelse

            </div>

        </section>



        {{-- ---- قراردادهای قبلی ---- --}}

        @if($building->contracts->count() > ($activeContract ? 1 : 0))

            <section class="building-block">

                <h2 class="building-block-title">قراردادها</h2>

                <div class="service-list">

                    @foreach($building->contracts as $contract)

                        <a href="{{ route('service.contracts.show', $contract) }}" class="service-card">

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
