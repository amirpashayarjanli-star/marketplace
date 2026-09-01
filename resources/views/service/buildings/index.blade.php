@extends('layouts.app')

@section('title', 'پرونده‌های من | پروسرویس')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="service-page-head">

            <div>
                <h1 class="wizard-title">پرونده‌های من</h1>
                <p class="wizard-subtitle">
                    برای هر ساختمان یک پرونده بسازید تا قرارداد، بیمه، تکنسین و
                    تاریخچه‌ی خرابی‌هایش یک‌جا باشد.
                </p>
            </div>

            <a href="{{ route('service.buildings.create') }}" class="btn btn-primary">
                پرونده‌ی جدید
            </a>

        </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif


        <div class="building-grid">

            @forelse($buildings as $building)

                <a href="{{ route('service.buildings.show', $building) }}" class="card building-card">

                    <div class="building-card-head">
                        <span class="building-code">{{ $building->code }}</span>

                        @if($building->activeContract)
                            <span class="badge badge-success">قرارداد فعال</span>
                        @else
                            <span class="badge badge-warning">بدون قرارداد</span>
                        @endif
                    </div>

                    <h2 class="building-card-title">{{ $building->title }}</h2>

                    <p class="building-card-meta">📍 {{ $building->fullAddress() ?: '—' }}</p>

                    <div class="building-card-foot">
                        <span>{{ $building->elevators_count }} دستگاه</span>
                        <span>{{ $building->service_requests_count }} خرابی ثبت‌شده</span>
                    </div>

                    @if($building->activeContract)
                        <p class="building-card-note">
                            {{ $building->activeContract->planLabel() }}
                            — تا {{ jdate($building->activeContract->ends_at) }}
                        </p>
                    @endif

                </a>

            @empty

                <div class="auction-board-empty" style="grid-column:1 / -1;">
                    <p>هنوز پرونده‌ای نساخته‌اید. اولین ساختمانتان را ثبت کنید.</p>
                    <a href="{{ route('service.buildings.create') }}" class="btn btn-primary">
                        ساخت اولین پرونده
                    </a>
                </div>

            @endforelse

        </div>


    </div>

</div>

@endsection
