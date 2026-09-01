@extends('layouts.app')

@section('title', 'قراردادهای سرویس')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        @include('admin.partials.nav')


        <div class="service-page-head">
            <div>
                <h1 class="wizard-title">قراردادهای سرویس</h1>
                <p class="wizard-subtitle">بررسی، قیمت‌گذاری و مدیریت قراردادهای پرو سرویس</p>
            </div>
        </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <div class="auction-tabs">

            <a href="{{ route('admin.contracts.index') }}"
               @class(['auction-tab', 'is-active' => ! $currentStatus])>همه</a>

            @foreach($statuses as $key => $label)
                <a href="{{ route('admin.contracts.index', ['status' => $key]) }}"
                   @class(['auction-tab', 'is-active' => $currentStatus === $key])>{{ $label }}</a>
            @endforeach

        </div>


        <div class="service-list">

            @forelse($contracts as $contract)

                <a href="{{ route('admin.contracts.show', $contract) }}" class="service-card">

                    <div class="service-card-head">
                        <span class="service-card-title">
                            {{ $contract->code }} — {{ $contract->building->title }}
                        </span>
                        <span class="badge @if($contract->isActive()) badge-success @elseif($contract->status === 'pending_review') badge-warning @elseif($contract->status === 'cancelled') badge-danger @endif">
                            {{ $contract->statusLabel() }}
                        </span>
                    </div>

                    <div class="service-card-meta">
                        مشتری: {{ $contract->building->customer->name }}
                        · {{ $contract->planLabel() }} / {{ $contract->termLabel() }}
                        · {{ $contract->elevator_count }} دستگاه
                        · {{ number_format($contract->total_amount) }} تومان
                    </div>

                    <div class="service-card-meta">
                        تکنسین: {{ $contract->technician?->name ?? $contract->technicianModeLabel() }}
                        @if($contract->ends_at)
                            · اعتبار تا {{ jdate($contract->ends_at) }}
                        @endif
                    </div>

                </a>

            @empty

                <p class="auction-blocked">قراردادی با این فیلتر پیدا نشد.</p>

            @endforelse

        </div>


    </div>

</div>

@endsection
