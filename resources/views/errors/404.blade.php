@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center relative overflow-hidden py-8 px-4">
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="text-center">
        <div class="mb-8">
            <h1 class="text-9xl font-bold bg-gradient-to-r from-blue-600 to-yellow-500 bg-clip-text text-transparent">
                404
            </h1>
        </div>

        <h2 class="text-3xl font-bold text-gray-800 mb-4">
            صفحه پیدا نشد
        </h2>

        <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
            متاسفانه صفحهٔ مورد نظر شما پیدا نشد. ممکن است حذف شده یا آدرس آن تغییر کرده باشد.
        </p>

        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('home') ?? '/' }}" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-2xl hover:shadow-lg transition">
                بازگشت به خانه
            </a>
            <a href="{{ route('login') }}" class="px-8 py-3 border-2 border-blue-600 text-blue-600 font-bold rounded-2xl hover:bg-blue-50 transition">
                ورود به حساب
            </a>
        </div>

        <div class="mt-12 text-sm text-gray-500">
            <p>کد خطا: 404</p>
        </div>
    </div>
</div>

@endsection
