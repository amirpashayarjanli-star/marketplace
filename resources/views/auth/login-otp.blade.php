@extends('layouts.app')

@section('content')

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
                    <i class="fa-solid fa-message text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-yellow-500 bg-clip-text text-transparent">
                    تایید کد
                </h1>
                <p class="text-gray-600 mt-2 text-sm">
                    کد 5 رقمی ارسال‌شده به شماره خود را وارد کنید
                </p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm text-red-700 p-4 rounded-2xl mb-6 text-sm">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.otp') }}" class="space-y-8">
                @csrf

                {{-- Mobile Number (Hidden but required) --}}
                <input type="hidden" name="mobile" value="">

                {{-- PIN Input Container --}}
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

                {{-- Instructions --}}
                <div class="text-center text-sm text-gray-600">
                    <p>کد را دریافت نکردید؟</p>
                    <button type="button" class="text-blue-600 hover:text-yellow-500 font-semibold transition mt-1" id="resend-btn">
                        ارسال مجدد کد
                    </button>
                    <span class="text-gray-500 ms-2" id="resend-timer"></span>
                </div>

                {{-- Mobile Number Input (Optional, for different number) --}}
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-phone text-blue-600 group-focus-within:text-yellow-500 transition"></i>
                    </div>
                    <input
                        type="tel"
                        name="mobile_input"
                        id="mobile-input"
                        placeholder="09123456789"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all"
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        شماره موبایل
                    </label>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-yellow-600 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 mt-8"
                >
                    <span>تایید و ورود</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>

                {{-- Back Link --}}
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-yellow-500 font-semibold transition">
                        بازگشت به ورود
                    </a>
                </div>
            </form>

        </div>

        {{-- Features Badge --}}
        <div class="mt-8 text-center text-xs text-gray-600">
            <div class="inline-flex items-center gap-4">
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-shield text-green-500"></i>
                    <span>امن</span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-zap text-yellow-500"></i>
                    <span>سریع</span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-mobile text-blue-500"></i>
                    <span>موبایل</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.digit-input');
    const otpCodeInput = document.getElementById('otp-code');
    const mobileInput = document.getElementById('mobile-input');
    const pinContainer = document.getElementById('pin-container');
    const resendBtn = document.getElementById('resend-btn');
    const resendTimer = document.getElementById('resend-timer');

    // Handle digit input
    inputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            // Only allow digits
            this.value = this.value.replace(/[^0-9]/g, '');

            // Move to next input
            if (this.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            // Update hidden input with complete code
            updateOtpCode();
        });

        input.addEventListener('keydown', function(e) {
            // Handle backspace
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                inputs[index - 1].focus();
            }

            // Handle arrow keys
            if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            if (e.key === 'ArrowLeft' && index > 0) {
                inputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/[^0-9]/g, '').slice(0, inputs.length);

            digits.split('').forEach((digit, i) => {
                if (inputs[i]) {
                    inputs[i].value = digit;
                }
            });

            updateOtpCode();
            inputs[Math.min(digits.length, inputs.length - 1)].focus();
        });
    });

    function updateOtpCode() {
        const code = Array.from(inputs).map(input => input.value).join('');
        otpCodeInput.value = code;

        // Add animation when code is complete
        if (code.length === inputs.length) {
            pinContainer.classList.add('scale-105');
            setTimeout(() => pinContainer.classList.remove('scale-105'), 200);
        }
    }

    // Mobile input auto-fill
    mobileInput.addEventListener('change', function() {
        document.querySelector('input[name="mobile"]').value = this.value;
    });

    // Resend button
    let resendCountdown = 0;
    resendBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (resendCountdown === 0) {
            resendCountdown = 60;
            resendBtn.disabled = true;
            resendBtn.classList.add('opacity-50', 'cursor-not-allowed');

            const interval = setInterval(() => {
                resendCountdown--;
                resendTimer.textContent = `(${resendCountdown}s)`;

                if (resendCountdown === 0) {
                    clearInterval(interval);
                    resendBtn.disabled = false;
                    resendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    resendTimer.textContent = '';
                }
            }, 1000);
        }
    });

    // Focus first input on load
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
