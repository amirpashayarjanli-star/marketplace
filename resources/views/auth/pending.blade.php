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
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl mb-4">
                    <i class="fa-solid fa-hourglass-half text-white text-2xl animate-spin" style="animation-duration: 2s;"></i>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-yellow-600 to-orange-500 bg-clip-text text-transparent">
                    انتظار تایید
                </h1>
                <p class="text-gray-600 mt-2 text-sm">
                    حساب شما در حال بررسی است
                </p>
            </div>

            {{-- Status Info --}}
            <div class="space-y-6">
                {{-- Status Card --}}
                <div class="backdrop-blur-sm bg-yellow-50/50 border-2 border-yellow-200/50 rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                                <i class="fa-solid fa-info text-yellow-600"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">درحال بررسی</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                تیم ما در حال بررسی اطلاعات حساب شما است. این معمولاً ۲۴ تا ۴۸ ساعت طول می‌کشد.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-800 mb-4">مراحل تایید</h3>

                    {{-- Step 1 --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div class="w-0.5 h-8 bg-gray-300 my-2"></div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">ثبت‌نام تکمیل شد</p>
                            <p class="text-sm text-gray-600">حساب شما با موفقیت ایجاد شد</p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-yellow-500 text-white flex items-center justify-center text-sm font-bold animate-pulse">
                                <i class="fa-solid fa-hourglass-half"></i>
                            </div>
                            <div class="w-0.5 h-8 bg-gray-300 my-2"></div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">در حال بررسی</p>
                            <p class="text-sm text-gray-600">تیم ما اطلاعات شما را بررسی می‌کند</p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">تایید نهایی</p>
                            <p class="text-sm text-gray-600">شما پیام تایید را دریافت خواهید کرد</p>
                        </div>
                    </div>
                </div>

                {{-- Helpful Info --}}
                <div class="backdrop-blur-sm bg-blue-50/50 border-2 border-blue-200/50 rounded-2xl p-5">
                    <h4 class="font-semibold text-gray-800 mb-3">نکات مهم</h4>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-circle-dot text-blue-600 mt-1"></i>
                            <span>بعد از تایید، ایمیل تایید دریافت خواهید کرد</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-circle-dot text-blue-600 mt-1"></i>
                            <span>می‌تونید از داشبورد بازدید کنید اما برخی ویژگی‌ها محدود هستند</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-circle-dot text-blue-600 mt-1"></i>
                            <span>در صورت سوال با ما تماس بگیرید</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-3 mt-8">
                <a
                    href="{{ route('dashboard') }}"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-yellow-600 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2"
                >
                    <span>رفتن به داشبورد</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <button
                    onclick="location.reload()"
                    class="w-full border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-3.5 rounded-2xl transition-all flex items-center justify-center gap-2"
                >
                    <span>بروزرسانی</span>
                    <i class="fa-solid fa-rotate"></i>
                </button>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-8 pt-6 border-t border-white/30">
                <p class="text-sm text-gray-600">
                    نیاز به کمک؟
                    <a href="#" class="text-blue-600 hover:text-yellow-500 font-semibold">تماس با پشتیبانی</a>
                </p>
            </div>

        </div>

        {{-- Contact Info --}}
        <div class="mt-8 text-center text-sm text-gray-600">
            <p>ایمیل: <span class="font-semibold">support@asansor-pro.ir</span></p>
            <p>تلفن: <span class="font-semibold">09343448008</span></p>
        </div>
    </div>
</div>

@endsection
