@extends('layouts.app')

@section('title', 'کار #' . $serviceRequest->id)

@section('content')

@php
    $actionLabels = [
        'accepted'    => 'پذیرفتن این کار',
        'on_the_way'  => 'در راه هستم',
        'arrived'     => 'به محل رسیدم',
        'in_progress' => 'شروع تعمیر',
        'completed'   => 'کار تمام شد',
    ];
@endphp

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro" style="text-align:start; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">

            <div>
                <h1 class="wizard-title" style="margin-bottom:4px;">کار #{{ $serviceRequest->id }}</h1>
                <p class="wizard-subtitle">{{ $serviceRequest->customer->name }}</p>
            </div>

            <span class="service-status service-status-{{ $serviceRequest->status }}" style="font-size:.9rem; padding:8px 18px;">
                {{ $serviceRequest->label() }}
            </span>

        </div>


        @if(session('success'))
            <div class="wizard-alert wizard-alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="wizard-alert wizard-alert-error">{{ session('error') }}</div>
        @endif


        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:10px;">شرح خرابی</h3>
            <p style="color:#334155; line-height:1.9;">{{ $serviceRequest->description }}</p>

            @if($serviceRequest->address)
                <p style="color:#64748b; font-size:.85rem; margin-top:10px;">📍 {{ $serviceRequest->address }}</p>
            @endif

            <p style="color:#0f172a; font-size:.9rem; margin-top:10px; font-weight:700;">
                تماس مشتری: {{ $serviceRequest->customer->mobile ?: $serviceRequest->customer->phone ?: 'ثبت نشده' }}
            </p>

        </div>


        @if($serviceRequest->invoice)

            <div class="wizard-form-card">
                <h3 class="wizard-progress-label" style="margin-bottom:10px;">سهم شما از این کار</h3>
                <p style="font-size:1.4rem; font-weight:900; color:#0f172a;">
                    {{ number_format($serviceRequest->invoice->technician_amount) }} تومان
                </p>
                <p class="wizard-hint">بعد از تایید مشتری، به کیف پول شما واریز می‌شود.</p>
            </div>

        @endif


        @if($nextStage)

            <div class="wizard-form-card">

                <form method="POST" action="{{ route('service.jobs.advance', $serviceRequest) }}">
                    @csrf
                    <button type="submit" class="wizard-btn wizard-btn-primary wizard-btn-block">
                        {{ $actionLabels[$nextStage] ?? 'ادامه' }}
                    </button>
                </form>

            </div>

        @elseif($serviceRequest->status === 'completed')

            <div class="wizard-status wizard-status-pending">
                <strong>منتظر تایید مشتری</strong>
                <span>پس از تایید تحویل و رضایت مشتری، مبلغ به کیف پول شما واریز می‌شود.</span>
            </div>

        @elseif($serviceRequest->status === 'confirmed')

            <div class="wizard-status wizard-status-approved">
                <strong>تسویه شد</strong>
                @if($serviceRequest->customer_rating)
                    <span>امتیاز مشتری: {{ $serviceRequest->customer_rating }} از ۵</span>
                @endif
                @if($serviceRequest->customer_feedback)
                    <span>{{ $serviceRequest->customer_feedback }}</span>
                @endif
            </div>

        @endif


        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:14px;">مراحل</h3>

            <div class="service-timeline">
                @foreach($serviceRequest->statusLogs as $log)
                    <div class="service-timeline-item">
                        <div class="service-timeline-label">{{ \App\Models\ServiceRequest::LABELS[$log->status] ?? $log->status }}</div>
                        @if($log->note)
                            <div class="service-timeline-time">{{ $log->note }}</div>
                        @endif
                        <div class="service-timeline-time">{{ $log->created_at->format('Y/m/d H:i') }}</div>
                    </div>
                @endforeach
            </div>

        </div>


    </div>

</div>

@endsection
