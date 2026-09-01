@extends('layouts.app')

@section('title', 'کارهای من')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro" style="text-align:start; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">

            <div>
                <h1 class="wizard-title" style="margin-bottom:4px;">کارهای پروسرویس</h1>
                <p class="wizard-subtitle">درخواست‌های تعمیری که به شما تخصیص داده شده</p>
            </div>

            <a href="{{ route('wallet') }}" class="wizard-btn wizard-btn-ghost">کیف پول</a>

        </div>


        <div class="service-list">

            @forelse($jobs as $job)

                <a href="{{ route('service.jobs.show', $job) }}" class="service-card">

                    <div class="service-card-head">
                        <span class="service-card-title">{{ $job->customer->name }}</span>
                        <span class="service-status service-status-{{ $job->status }}">{{ $job->label() }}</span>
                    </div>

                    <p class="service-card-desc">{{ \Illuminate\Support\Str::limit($job->description, 100) }}</p>

                    <div class="service-card-meta">
                        {{ jdatetime($job->created_at) }}
                        @if($job->invoice)
                            · سهم شما: {{ number_format($job->invoice->technician_amount) }} تومان
                        @endif
                    </div>

                </a>

            @empty

                <div class="wizard-form-card" style="text-align:center;">
                    <p class="wizard-subtitle">فعلاً کاری برای شما تخصیص داده نشده.</p>
                </div>

            @endforelse

        </div>


        {{-- ---- بازدیدهای دوره‌ای ---- --}}

        @if($visits->isNotEmpty())

            <h3 class="wizard-progress-label" style="margin-top:28px; margin-bottom:14px;">
                بازدیدهای دوره‌ای ({{ $visits->count() }})
            </h3>

            @foreach($visits as $visit)

                <div class="card visit-item @if($visit->isOverdue()) is-overdue @endif">

                    <div>
                        <strong>{{ $visit->contract->building->title }}</strong>
                        <p class="building-card-meta">
                            موعد: {{ jdate($visit->due_on) }}
                            @if($visit->isOverdue())
                                — عقب‌افتاده
                            @endif
                        </p>
                        <p class="building-card-meta">
                            📍 {{ $visit->contract->building->fullAddress() }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('service.visits.complete', $visit) }}"
                          class="visit-item-form">
                        @csrf
                        <input type="text" name="report" class="input"
                               placeholder="گزارش بازدید" required>
                        <button type="submit" class="btn btn-sm btn-success">ثبت انجام</button>
                    </form>

                </div>

            @endforeach

        @endif


        @if($history->isNotEmpty())

            <h3 class="wizard-progress-label" style="margin-top:28px; margin-bottom:14px;">کارهای قبلی</h3>

            <div class="service-list">
                @foreach($history as $job)
                    <a href="{{ route('service.jobs.show', $job) }}" class="service-card" style="opacity:.75;">
                        <div class="service-card-head">
                            <span class="service-card-title">{{ $job->customer->name }}</span>
                            <span class="service-status service-status-{{ $job->status }}">{{ $job->label() }}</span>
                        </div>
                        <div class="service-card-meta">{{ jdatetime($job->created_at) }}</div>
                    </a>
                @endforeach
            </div>

        @endif


    </div>

</div>

@endsection
