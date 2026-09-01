@extends('layouts.app')

@section('title', 'خرابی #' . $serviceRequest->id)

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro" style="text-align:start; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">

            <div>
                <h1 class="wizard-title" style="margin-bottom:4px;">خرابی #{{ $serviceRequest->id }}</h1>
                <p class="wizard-subtitle">{{ jdatetime($serviceRequest->created_at) }}</p>
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


        {{-- شرح خرابی --}}

        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:10px;">شرح خرابی</h3>
            <p style="color:var(--text); line-height:1.9;">{{ $serviceRequest->description }}</p>

            @if($serviceRequest->address)
                <p style="color:var(--text-muted); font-size:.85rem; margin-top:10px;">📍 {{ $serviceRequest->address }}</p>
            @endif

            @if($serviceRequest->technician)
                <p style="color:var(--text); font-size:.9rem; margin-top:10px; font-weight:700;">
                    تکنسین: {{ $serviceRequest->technician->name }}
                    @if($serviceRequest->technician->mobile)
                        · {{ $serviceRequest->technician->mobile }}
                    @endif
                </p>
            @endif

        </div>


        {{-- فاکتور --}}

        @if($serviceRequest->invoice)

            <div class="wizard-form-card">

                <h3 class="wizard-progress-label" style="margin-bottom:14px;">
                    فاکتور
                    @if($serviceRequest->has_insurance)
                        <span class="badge" style="background:var(--pastel-success-bg);color:var(--pastel-success-text);margin-inline-start:8px;">تحت پوشش بیمه</span>
                    @endif
                </h3>

                <table class="service-invoice-table">
                    <thead>
                        <tr><th>شرح</th><th>مبلغ (تومان)</th></tr>
                    </thead>
                    <tbody>
                        @foreach($serviceRequest->invoice->items as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ number_format($item->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr class="service-invoice-total-row">
                            <td>جمع کل</td>
                            <td>{{ number_format($serviceRequest->invoice->subtotal) }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>

        @endif


        {{-- انتخاب تکنسین --}}

        @if($technicians !== null)

            <div class="wizard-form-card">

                <h3 class="wizard-progress-label" style="margin-bottom:14px;">انتخاب تکنسین</h3>

                @if($customer->dedicatedTechnician)
                    <p class="wizard-hint" style="margin-bottom:14px;">
                        تکنسین اختصاصی شما «{{ $customer->dedicatedTechnician->name }}» از پایین انتخابش کنید، یا هرکس دیگه‌ای رو ترجیح می‌دید.
                    </p>
                @endif

                <form method="POST" action="{{ route('service.technician', $serviceRequest) }}" class="wizard-form">

                    @csrf

                    <div class="service-tech-grid">

                        @forelse($technicians as $tech)

                            <label class="service-tech-card">

                                <input type="radio" name="technician_id" value="{{ $tech->id }}"
                                       {{ $customer->dedicated_technician_id === $tech->id ? 'checked' : '' }} required>

                                <span class="service-tech-body">
                                    <span class="service-tech-name">{{ $tech->name }}</span>
                                    <span class="service-tech-meta">
                                        {{ $tech->city ?: 'نامشخص' }}
                                        @if($tech->rating) · ⭐ {{ $tech->rating }} @endif
                                        @if($customer->dedicated_technician_id === $tech->id) · اختصاصی شما @endif
                                    </span>
                                </span>

                            </label>

                        @empty

                            <p class="wizard-subtitle">فعلاً تکنسین فعالی برای انتخاب موجود نیست.</p>

                        @endforelse

                    </div>


                    <label style="display:flex; align-items:center; gap:8px; margin-top:16px; font-size:.85rem; color:var(--text);">
                        <input type="checkbox" name="make_dedicated" value="1">
                        این تکنسین برای همیشه تکنسین اختصاصی من باشد
                    </label>


                    <div class="wizard-form-actions">
                        <span></span>
                        <button type="submit" class="wizard-btn wizard-btn-primary">تایید تکنسین</button>
                    </div>

                </form>

            </div>

        @endif


        {{-- تایید نهایی مشتری --}}

        @if($serviceRequest->status === 'completed')

            <div class="wizard-form-card">

                <h3 class="wizard-progress-label" style="margin-bottom:14px;">تایید تحویل و رضایت</h3>

                <p class="wizard-hint" style="margin-bottom:16px;">
                    تکنسین کار را تمام‌شده اعلام کرده. لطفاً بعد از بازدید، تحویل و رضایت خود را تایید کنید تا مبلغ به تکنسین واریز شود.
                </p>

                <form method="POST" action="{{ route('service.confirm', $serviceRequest) }}" class="wizard-form">

                    @csrf

                    <div class="wizard-field">
                        <label class="wizard-label">امتیاز شما</label>
                        <div class="service-rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star-{{ $i }}" value="{{ $i }}" required>
                                <label for="star-{{ $i }}">★</label>
                            @endfor
                        </div>
                    </div>

                    <div class="wizard-field">
                        <label for="f-feedback" class="wizard-label">نظر شما (اختیاری)</label>
                        <textarea id="f-feedback" name="feedback" rows="3" class="wizard-input"></textarea>
                    </div>

                    <div class="wizard-form-actions">
                        <span></span>
                        <button type="submit" class="wizard-btn wizard-btn-primary">تایید تحویل و پرداخت</button>
                    </div>

                </form>

            </div>

        @endif


        {{-- تایم‌لاین --}}

        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:14px;">مراحل</h3>

            <div class="service-timeline">
                @forelse($serviceRequest->statusLogs as $log)
                    <div class="service-timeline-item">
                        <div class="service-timeline-label">{{ \App\Models\ServiceRequest::LABELS[$log->status] ?? $log->status }}</div>
                        @if($log->note)
                            <div class="service-timeline-time">{{ $log->note }}</div>
                        @endif
                        <div class="service-timeline-time">{{ jdatetime($log->created_at) }}</div>
                    </div>
                @empty
                    {{--
                    | خرابی‌هایی که پیش از راه‌افتادن ثبت مراحل ساخته شده‌اند
                    | لاگی ندارند. بدون این، فقط عنوان «مراحل» می‌ماند و
                    | زیرش خالی — مشتری فکر می‌کند صفحه ناقص بالا آمده.
                    --}}
                    <p class="service-timeline-time">
                        هنوز مرحله‌ای ثبت نشده است.
                    </p>
                @endforelse
            </div>

        </div>


    </div>

</div>

@endsection
