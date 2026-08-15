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
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-600 to-pink-500 rounded-2xl mb-4">
                    <i class="fa-solid fa-briefcase text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-pink-500 bg-clip-text text-transparent">
                    اطلاعات کارفرما
                </h1>
                <p class="text-gray-600 mt-2 text-sm">
                    اطلاعات پروژه و مجموعهٔ خود را تکمیل کنید
                </p>

                {{-- Progress --}}
                <div class="flex items-center justify-center gap-2 mt-6">
                    <div class="w-8 h-8 rounded-full bg-gray-400 text-white flex items-center justify-center text-xs font-bold">✓</div>
                    <div class="w-8 h-8 rounded-full bg-gray-400 text-white flex items-center justify-center text-xs font-bold">✓</div>
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">3</div>
                </div>
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
            <form method="POST" action="{{ route('register.profile.store') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-user text-pink-600 group-focus-within:text-pink-500 transition"></i>
                    </div>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="نام کارفرما یا نام مجموعه"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('name') ? 'ring-2 ring-red-500' : '' }}"
                        required
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        نام
                    </label>
                </div>

                {{-- City --}}
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none z-10">
                        <i class="fa-solid fa-map-location-dot text-pink-600 group-focus-within:text-pink-500 transition"></i>
                    </div>
                    <select
                        name="city"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('city') ? 'ring-2 ring-red-500' : '' }}"
                        required
                    >
                        <option value="">انتخاب شهر...</option>
                        @php
                            use App\Enums\IranianCity;
                            $cities = IranianCity::all();
                        @endphp
                        @foreach($cities as $key => $city)
                            <option value="{{ $key }}" {{ old('city') === $key ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        شهر
                    </label>
                </div>

                {{-- Phone --}}
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-phone text-pink-600 group-focus-within:text-pink-500 transition"></i>
                    </div>
                    <input
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="0211234567"
                        inputmode="numeric"
                        pattern="[0-9\s\-\+\(\)]{10,20}"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('phone') ? 'ring-2 ring-red-500' : '' }}"
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        شماره تماس
                    </label>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 mt-8"
                >
                    <span>ثبت اطلاعات و ارسال برای تایید</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>

                {{-- Back Link --}}
                <div class="text-center">
                    <a href="{{ route('register.type') }}" class="text-sm text-pink-600 hover:text-pink-500 font-semibold transition">
                        بازگشت
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
