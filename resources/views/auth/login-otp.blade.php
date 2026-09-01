@extends('layouts.app')

@section('content')

@php
    // مرحله‌ی اول: هنوز شماره‌ای نداریم و باید کد بفرستیم.
    // مرحله‌ی دوم: کد رفته و منتظر وارد کردنش هستیم.
    $mobile = $mobile ?? session('login_otp_mobile');
    $awaitingCode = filled($mobile);
@endphp

<div class="min-h-screen flex items-center justify-center relative overflow-hidden py-8 px-4">
    {{-- Background gradient --}}
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="backdrop-blur-xl bg-white/30 border border-white/40 rounded-3xl shadow-2xl p-8 md:p-10">

            {{-- Header --}}
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-yellow-500 rounded-2xl mb-4">
                    <x-ui.icon name="message" class="text-white text-2xl" />
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-yellow-500 bg-clip-text text-transparent">
                    {{ $awaitingCode ? 'تایید کد' : 'ورود با کد یکبار مصرف' }}
                </h1>
                <p class="text-gray-600 mt-2 text-sm">
                    @if($awaitingCode)
                        کد ۵ رقمی ارسال‌شده به {{ $mobile }} را وارد کنید
                    @else
                        شماره موبایل خود را وارد کنید تا کد ورود برایتان ارسال شود
                    @endif
                </p>
            </div>

            {{-- Success --}}
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 backdrop-blur-sm text-green-800 p-4 rounded-2xl mb-6 text-sm">
                    <div class="flex items-start gap-3">
                        <x-ui.icon name="circle-check" class="mt-0.5 flex-shrink-0" />
                        <div>{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm text-red-700 p-4 rounded-2xl mb-6 text-sm">
                    <div class="flex items-start gap-3">
                        <x-ui.icon name="circle-exclamation" class="mt-0.5 flex-shrink-0" />
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif


            @if(! $awaitingCode)

                {{-- مرحله ۱ — گرفتن شماره و ارسال کد --}}
                <form method="POST" action="{{ route('login.otp.send') }}" class="space-y-8">
                    @csrf

                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <x-ui.icon name="phone" class="text-blue-600 group-focus-within:text-yellow-500 transition" />
                        </div>
                        <input
                            type="tel"
                            name="mobile"
                            inputmode="numeric"
                            value="{{ old('mobile') }}"
                            placeholder="09123456789"
                            required
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all"
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            شماره موبایل
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-yellow-600 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2"
                    >
                        <span>ارسال کد</span>
                        <x-ui.icon name="paper-plane" />
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-yellow-500 font-semibold transition">
                            ورود با رمز عبور
                        </a>
                    </div>
                </form>

            @else

                {{-- مرحله ۲ — وارد کردن کد --}}
                <form method="POST" action="{{ route('login.otp') }}" class="space-y-8">
                    @csrf

                    <input type="hidden" name="mobile" value="{{ $mobile }}">

                    <div class="flex gap-3 justify-center" id="pin-container">
                        @for($i = 1; $i <= 5; $i++)
                            <input
                                type="text"
                                inputmode="numeric"
                                maxlength="1"
                                class="w-14 h-14 text-center text-2xl font-bold rounded-2xl bg-white/50 border-2 border-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all digit-input"
                                data-index="{{ $i - 1 }}"
                                placeholder="•"
                            >
                        @endfor
                    </div>

                    <input type="hidden" id="otp-code" name="code" value="">

                    <div class="text-center text-sm text-gray-600">
                        <p>کد را دریافت نکردید؟</p>
                        <button type="submit" form="resend-form" class="text-blue-600 hover:text-yellow-500 font-semibold transition mt-1" id="resend-btn">
                            ارسال مجدد کد
                        </button>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-yellow-600 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 mt-8"
                    >
                        <span>تایید و ورود</span>
                        <x-ui.icon name="arrow-left" />
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-yellow-500 font-semibold transition">
                            بازگشت به ورود
                        </a>
                    </div>
                </form>

                {{-- فرم ارسال مجدد جداست، چون فرم تودرتو در HTML مجاز نیست --}}
                <form method="POST" action="{{ route('login.otp.send') }}" id="resend-form" class="hidden">
                    @csrf
                    <input type="hidden" name="mobile" value="{{ $mobile }}">
                </form>

            @endif

        </div>

        {{-- Features Badge --}}
        <div class="mt-8 text-center text-xs text-gray-600">
            <div class="inline-flex items-center gap-4">
                <div class="flex items-center gap-1">
                    <x-ui.icon name="shield" class="text-green-500" />
                    <span>امن</span>
                </div>
                <div class="flex items-center gap-1">
                    <x-ui.icon name="bolt" class="text-yellow-500" />
                    <span>سریع</span>
                </div>
                <div class="flex items-center gap-1">
                    <x-ui.icon name="mobile" class="text-blue-500" />
                    <span>موبایل</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.digit-input');
    if (! inputs.length) return;

    const otpCodeInput = document.getElementById('otp-code');
    const pinContainer = document.getElementById('pin-container');

    function updateOtpCode() {
        const code = Array.from(inputs).map(input => input.value).join('');
        otpCodeInput.value = code;

        if (code.length === inputs.length) {
            pinContainer.classList.add('scale-105');
            setTimeout(() => pinContainer.classList.remove('scale-105'), 200);
        }
    }

    inputs.forEach((input, index) => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            updateOtpCode();
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
            if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            if (e.key === 'ArrowLeft' && index > 0) {
                inputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', function (e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/[^0-9]/g, '').slice(0, inputs.length);

            digits.split('').forEach((digit, i) => {
                if (inputs[i]) inputs[i].value = digit;
            });

            updateOtpCode();
            inputs[Math.min(digits.length, inputs.length - 1)].focus();
        });
    });

    inputs[0].focus();
});
</script>

<style>
.digit-input {
    transition: all 0.3s ease;
}

.digit-input:focus {
    transform: scale(1.1);
}

#pin-container {
    transition: transform 0.2s ease;
}
</style>

@endsection
