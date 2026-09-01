@extends('layouts.app')

@section('title', 'مدیریت پروسرویس')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        <div class="wizard-intro" style="text-align:start;">
            <h1 class="wizard-title">مدیریت پروسرویس</h1>
            <p class="wizard-subtitle">همه‌ی خرابی‌های ثبت‌شده توسط مشتریان</p>
        </div>


        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:8px;">

            <a href="{{ route('admin.service.index') }}"
               class="wizard-btn {{ !$currentStatus ? 'wizard-btn-primary' : 'wizard-btn-ghost' }}" style="padding:8px 16px; height:auto;">
                همه
            </a>

            @foreach($statuses as $key => $label)
                <a href="{{ route('admin.service.index', ['status' => $key]) }}"
                   class="wizard-btn {{ $currentStatus === $key ? 'wizard-btn-primary' : 'wizard-btn-ghost' }}" style="padding:8px 16px; height:auto; font-size:.8rem;">
                    {{ $label }}
                </a>
            @endforeach

        </div>


        <div class="service-list">

            @forelse($requests as $request)

                <a href="{{ route('admin.service.show', $request) }}" class="service-card">

                    <div class="service-card-head">
                        <span class="service-card-title">
                            #{{ $request->id }} — {{ $request->customer->name }}
                        </span>
                        <span class="service-status service-status-{{ $request->status }}">{{ $request->label() }}</span>
                    </div>

                    <p class="service-card-desc">{{ \Illuminate\Support\Str::limit($request->description, 100) }}</p>

                    <div class="service-card-meta">
                        {{ $request->created_at->format('Y/m/d H:i') }}
                        @if($request->technician) · تکنسین: {{ $request->technician->name }} @endif
                        @if($request->invoice) · {{ number_format($request->invoice->subtotal) }} تومان @endif
                    </div>

                </a>

            @empty

                <div class="wizard-form-card" style="text-align:center;">
                    <p class="wizard-subtitle">موردی یافت نشد.</p>
                </div>

            @endforelse

        </div>


    </div>

</div>

@endsection
