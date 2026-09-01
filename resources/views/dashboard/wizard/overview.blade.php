@extends('layouts.app')

@section('title', 'تکمیل پروفایل')

@section('content')

@php
    $user = auth()->user();
@endphp

<div class="wizard-page">

    <div class="wizard-shell">


        {{-- وضعیت کلی حساب --}}

        @if($user->status === 'approved')

            <div class="wizard-status wizard-status-approved">
                <strong>پروفایل شما تایید شده است.</strong>
                <span>هم‌اکنون در سایت نمایش داده می‌شوید.</span>
            </div>

        @elseif($user->status === 'pending')

            <div class="wizard-status wizard-status-pending">
                <strong>در انتظار تایید مدیر</strong>
                <span>پروفایل شما کامل است و برای بررسی ارسال شده. تا زمان تایید، در سایت نمایش داده نمی‌شوید.</span>
            </div>

        @elseif($user->status === 'rejected')

            <div class="wizard-status wizard-status-rejected">
                <strong>حساب شما تایید نشد.</strong>
                <span>برای پیگیری با پشتیبانی تماس بگیرید.</span>
            </div>

        @else

            <div class="wizard-status wizard-status-incomplete">
                <strong>پروفایل شما هنوز کامل نیست.</strong>
                <span>تا زمانی که همه‌ی مراحل تکمیل و توسط مدیر تایید نشود، در سایت نمایش داده نمی‌شوید.</span>
            </div>

        @endif


        @if(session('success'))
            <div class="wizard-alert wizard-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="wizard-alert wizard-alert-error">
                {{ session('error') }}
            </div>
        @endif


        {{-- نوار پیشرفت --}}

        <div class="wizard-progress-card">

            <div class="wizard-progress-head">

                <span class="wizard-progress-label">
                    تکمیل پروفایل
                </span>

                <span class="wizard-progress-value">
                    {{ $percent }}٪
                </span>

            </div>

            <div class="wizard-progress-track">
                <div class="wizard-progress-fill" style="width: {{ $percent }}%"></div>
            </div>

            <p class="wizard-progress-note">
                {{ $wizard->completedStepCount() }} از {{ $wizard->totalStepCount() }} مرحله تکمیل شده
            </p>

        </div>


        {{-- فهرست مراحل --}}

        <div class="wizard-steps">

            @foreach($steps as $key => $step)

                @php
                    $done = $statuses[$key];
                    $isNext = ($key === $next);
                @endphp

                <a href="{{ route('profile.wizard.step', $key) }}"
                   class="wizard-step-row {{ $done ? 'is-done' : '' }} {{ $isNext ? 'is-next' : '' }}">

                    <span class="wizard-step-mark">
                        {{ $done ? '✓' : $loop->iteration }}
                    </span>

                    <span class="wizard-step-text">

                        <span class="wizard-step-title">
                            {{ $step['title'] }}
                        </span>

                        <span class="wizard-step-meta">
                            @if($done)
                                تکمیل شده
                            @else
                                {{ count($wizard->requiredFields($key)) }} فیلد باقی‌مانده
                            @endif
                        </span>

                    </span>

                    <span class="wizard-step-action">
                        {{ $done ? 'ویرایش' : 'تکمیل' }}
                    </span>

                </a>

            @endforeach

        </div>


        {{-- ارسال برای بررسی --}}

        @if($wizard->isComplete() && in_array($user->status, ['incomplete', 'rejected'], true))

            <form method="POST" action="{{ route('profile.wizard.submit') }}" class="wizard-submit">

                @csrf

                <p class="wizard-submit-note">
                    همه‌ی مراحل کامل شده است. با ارسال برای بررسی، پروفایل شما در صف تایید مدیر قرار می‌گیرد.
                </p>

                <button type="submit" class="wizard-btn wizard-btn-primary">
                    ارسال برای بررسی
                </button>

            </form>

        @elseif(! $wizard->isComplete())

            <a href="{{ route('profile.wizard.step', $next) }}" class="wizard-btn wizard-btn-primary wizard-btn-block">
                ادامه از مرحله «{{ $steps[$next]['title'] }}»
            </a>

        @endif


    </div>

</div>

@endsection
