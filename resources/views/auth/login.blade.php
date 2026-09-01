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
                <img src="{{ asset('images/logo/logo-asansor-pro.png') }}" alt="آسانسور پرو" class="w-20 h-20 mx-auto mb-4 drop-shadow-lg">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-yellow-500 bg-clip-text text-transparent">
                    ورود
                </h1>
                <p class="text-gray-600 mt-2 text-sm">
                    به آسانسور پرو خوش آمدید
                </p>
            </div>

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

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Mobile Field --}}
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <x-ui.icon name="phone" class="text-blue-600 group-focus-within:text-yellow-500 transition" />
                    </div>
                    <input
                        type="tel"
                        name="mobile"
                        value="{{ old('mobile') }}"
                        placeholder="09123456789"
                        pattern="[0-9\s\-\+\(\)]{10,20}"
                        inputmode="numeric"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('mobile') ? 'ring-2 ring-red-500' : '' }}"
                        required
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        شماره موبایل
                    </label>
                </div>

                {{-- Password Field --}}
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <x-ui.icon name="lock" class="text-blue-600 group-focus-within:text-yellow-500 transition" />
                    </div>
                    <button
                        type="button"
                        class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-600 hover:text-blue-600 transition toggle-password"
                        data-target="password-field"
                        aria-label="نمایش رمز عبور"
                    >
                        <x-ui.icon name="eye" class="icon-eye" />
                        <x-ui.icon name="eye-slash" class="icon-eye-slash hidden" />
                    </button>
                    <input
                        id="password-field"
                        type="password"
                        name="password"
                        placeholder="رمز عبور خود را وارد کنید"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 pl-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('password') ? 'ring-2 ring-red-500' : '' }}"
                        required
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        رمز عبور
                    </label>
                </div>

                {{-- Remember & Forgot Password --}}
                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500">
                        <span class="group-hover:text-blue-600 transition">مرا به خاطر بسپار</span>
                    </label>
                    {{-- بازیابی رمز از طریق ایمیل نداریم؛ راه واقعی ورودِ
                         کاربری که رمزش را فراموش کرده، همان ورود با کد
                         یکبار مصرف است. قبلاً این لینک فقط یک alert با
                         راهنمای نادرست نشان می‌داد. --}}
                    <a href="{{ route('login.otp') }}" class="text-sm text-blue-600 hover:text-yellow-500 font-semibold transition">
                        رمز عبور را فراموش کرده‌اید؟
                    </a>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-yellow-600 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 mt-8"
                >
                    <span>ورود به حساب</span>
                    <x-ui.icon name="arrow-left" />
                </button>

                {{-- OTP Alternative --}}
                <div class="relative flex items-center gap-3 my-6">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent to-gray-300"></div>
                    <span class="text-xs text-gray-500">یا</span>
                    <div class="flex-1 h-px bg-gradient-to-l from-transparent to-gray-300"></div>
                </div>

                <a
                    href="{{ route('login.otp') }}"
                    class="w-full border-2 border-yellow-500 text-yellow-600 hover:bg-yellow-50 font-bold py-3.5 rounded-2xl transition-all duration-300 flex items-center justify-center gap-2"
                >
                    <x-ui.icon name="message" />
                    <span>ورود با کد یکبار مصرف</span>
                </a>
            </form>

            {{-- Sign Up Link --}}
            <div class="text-center mt-8 pt-6 border-t border-white/30">
                <p class="text-gray-700 text-sm">
                    آیا حساب کاربری ندارید؟
                    <a
                        href="{{ route('register') }}"
                        class="text-blue-600 font-bold hover:text-yellow-500 transition ml-1"
                    >
                        ثبت نام کنید
                    </a>
                </p>
            </div>
        </div>

        {{-- Features Badge --}}
        <div class="mt-8 text-center text-xs text-gray-600">
            <div class="inline-flex items-center gap-4">
                <div class="flex items-center gap-1">
                    <x-ui.icon name="shield" class="text-green-500" />
                    <span>امن</span>
                </div>
                <div class="flex items-center gap-1">
                    <x-ui.icon name="zap" class="text-yellow-500" />
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
    // آیکون‌ها SVG درون‌خطی‌اند نه فونت‌آیکون؛ کد قبلی دنبال یک تگ <i>
    // می‌گشت که وجود نداشت و هر بار کلیک، خطای JS می‌داد و آیکون چشم
    // هیچ‌وقت عوض نمی‌شد. حالا هر دو آیکون رندر می‌شوند و جا‌به‌جا می‌شوند.
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            if (! input) return;

            const showing = input.type === 'text';
            input.type = showing ? 'password' : 'text';

            this.querySelector('.icon-eye')?.classList.toggle('hidden', ! showing);
            this.querySelector('.icon-eye-slash')?.classList.toggle('hidden', showing);
            this.setAttribute('aria-label', showing ? 'نمایش رمز عبور' : 'پنهان کردن رمز عبور');
        });
    });
</script>

@endsection
