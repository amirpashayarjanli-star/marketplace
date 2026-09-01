@extends('layouts.app')

@section('title', 'پروسرویس')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro" style="text-align:start; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">

            <div>
                <h1 class="wizard-title" style="margin-bottom:4px;">سلام {{ $customer->name }}</h1>
                <p class="wizard-subtitle">خرابی‌های ثبت‌شده‌ی شما</p>
            </div>

            <a href="{{ route('service.create') }}" class="wizard-btn wizard-btn-primary">
                ثبت خرابی جدید
            </a>

        </div>


        @if(session('success'))
            <div class="wizard-alert wizard-alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="wizard-alert wizard-alert-error">{{ session('error') }}</div>
        @endif


        @if($customer->dedicatedTechnician)
            <div class="wizard-status wizard-status-approved">
                <strong>تکنسین اختصاصی شما: {{ $customer->dedicatedTechnician->name }}</strong>
                <span>خرابی‌های بعدی به‌طور پیش‌فرض برای همین تکنسین ارسال می‌شوند.</span>
            </div>
        @endif


        <div class="service-list">

            @forelse($requests as $request)

                <a href="{{ route('service.show', $request) }}" class="service-card">

                    <div class="service-card-head">
                        <span class="service-card-title">خرابی #{{ $request->id }}</span>
                        <span class="service-status service-status-{{ $request->status }}">{{ $request->label() }}</span>
                    </div>

                    <p class="service-card-desc">{{ \Illuminate\Support\Str::limit($request->description, 100) }}</p>

                    <div class="service-card-meta">
                        {{ $request->created_at->format('Y/m/d H:i') }}
                        @if($request->technician)
                            · تکنسین: {{ $request->technician->name }}
                        @endif
                        @if($request->invoice)
                            · مبلغ فاکتور: {{ number_format($request->invoice->subtotal) }} تومان
                        @endif
                    </div>

                </a>

            @empty

                <div class="wizard-form-card" style="text-align:center;">
                    <p class="wizard-subtitle" style="margin-bottom:16px;">هنوز خرابی‌ای ثبت نکرده‌اید.</p>
                    <a href="{{ route('service.create') }}" class="wizard-btn wizard-btn-primary">ثبت اولین خرابی</a>
                </div>

            @endforelse

        </div>


    </div>

</div>

@endsection
