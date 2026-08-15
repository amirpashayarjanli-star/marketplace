@extends('dashboard.layouts.dashboard')

@section('content')

<div class="min-h-screen py-8 px-4">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">
            ✏️ ویرایش پروفایل کارفرما
        </h1>
        <p class="text-gray-600">
            اطلاعات سازمان خود را بروزرسانی کنید
        </p>
    </div>

    {{-- Card --}}
    <div class="backdrop-blur-xl bg-white/80 border border-white/40 rounded-3xl shadow-xl p-8 md:p-10 max-w-4xl">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-gradient-to-r from-pink-500/20 to-rose-500/20 border border-pink-500/50 text-pink-700 p-4 rounded-2xl mb-6 flex items-start gap-3">
                <i class="fa-solid fa-circle-check mt-1 flex-shrink-0 text-pink-600"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- Errors --}}
        @if($errors->any())
            <div class="bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-500/50 text-red-700 p-4 rounded-2xl mb-6">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-1 flex-shrink-0 text-red-600"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if($profile)
            <form method="POST" action="{{ route('dashboard.profile.update') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Name --}}
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fa-solid fa-briefcase text-pink-600 group-focus-within:text-pink-500 transition"></i>
                        </div>
                        <input
                            type="text"
                            name="name"
                            value="{{ $profile->name }}"
                            placeholder="نام سازمان یا پروژه"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('name') ? 'ring-2 ring-red-500' : '' }}"
                            required
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            نام سازمان
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
                            value="{{ $profile->phone }}"
                            placeholder="026-12345678"
                            inputmode="numeric"
                            pattern="[0-9\s\-\+\(\)]{10,20}"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('phone') ? 'ring-2 ring-red-500' : '' }}"
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            شماره تماس
                        </label>
                    </div>

                    {{-- City --}}
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none z-10">
                            <i class="fa-solid fa-map-location-dot text-pink-600 group-focus-within:text-pink-500 transition"></i>
                        </div>
                        <select
                            name="city"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('city') ? 'ring-2 ring-red-500' : '' }}"
                            required
                        >
                            <option value="">انتخاب شهر...</option>
                            @foreach(\App\Enums\IranianCity::all() as $key => $city)
                                <option value="{{ $key }}" {{ $profile->city === $key ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            شهر
                        </label>
                    </div>

                    {{-- Province --}}
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fa-solid fa-map text-pink-600 group-focus-within:text-pink-500 transition"></i>
                        </div>
                        <input
                            type="text"
                            name="province"
                            value="{{ $profile->province }}"
                            placeholder="استان"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all"
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            استان
                        </label>
                    </div>
                </div>

                {{-- Email --}}
                <div class="relative group">
                    <div class="absolute top-4 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-envelope text-pink-600 group-focus-within:text-pink-500 transition"></i>
                    </div>
                    <input
                        type="email"
                        name="email"
                        value="{{ $profile->email }}"
                        placeholder="ایمیل سازمان"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all {{ $errors->has('email') ? 'ring-2 ring-red-500' : '' }}"
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        ایمیل
                    </label>
                </div>

                {{-- Address --}}
                <div class="relative group">
                    <div class="absolute top-4 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-location-dot text-pink-600 group-focus-within:text-pink-500 transition"></i>
                    </div>
                    <textarea
                        name="address"
                        placeholder="آدرس کامل سازمان"
                        rows="3"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all"
                    >{{ $profile->address }}</textarea>
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        آدرس
                    </label>
                </div>

                {{-- Description --}}
                <div class="relative group">
                    <div class="absolute top-4 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-align-left text-pink-600 group-focus-within:text-pink-500 transition"></i>
                    </div>
                    <textarea
                        name="description"
                        placeholder="درباره سازمان و پروژه‌های خود توضیح دهید"
                        rows="5"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent backdrop-blur-sm transition-all"
                    >{{ $profile->description }}</textarea>
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        توضیحات
                    </label>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 mt-8"
                >
                    <span>💾 ذخیره تغییرات</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </form>

        @else
            <div class="text-center py-12">
                <i class="fa-solid fa-info-circle text-3xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 text-lg">
                    پروفایل کارفرما یافت نشد.
                </p>
            </div>
        @endif

    </div>

</div>

@endsection
