@extends('layouts.app')

@section('title', 'تکمیل اطلاعات')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro">

            <h1 class="wizard-title">
                خوش آمدید به پروسرویس
            </h1>

            <p class="wizard-subtitle">
                فقط چند مورد کوتاه — اسم، شماره تماس و آدرس ساختمانی که آسانسورش نیاز به سرویس داره.
            </p>

        </div>


        <div class="wizard-form-card">

            <form method="POST" action="{{ route('service.setup.store') }}" class="wizard-form">

                @csrf


                <div class="wizard-field">
                    <label for="f-name" class="wizard-label">نام و نام خانوادگی <span class="wizard-required">*</span></label>
                    <input id="f-name" type="text" name="name" value="{{ old('name') }}" class="wizard-input @error('name') has-error @enderror" required>
                    @error('name')<p class="wizard-error">{{ $message }}</p>@enderror
                </div>


                <div class="wizard-field">
                    <label for="f-phone" class="wizard-label">شماره موبایل <span class="wizard-required">*</span></label>
                    <input id="f-phone" type="tel" name="phone" value="{{ old('phone') }}" class="wizard-input @error('phone') has-error @enderror" dir="ltr" required>
                    <p class="wizard-hint">مثال: 09121234567</p>
                    @error('phone')<p class="wizard-error">{{ $message }}</p>@enderror
                </div>


                <div class="wizard-field">
                    <label for="f-province" class="wizard-label">استان <span class="wizard-required">*</span></label>
                    <select id="f-province" name="province" class="wizard-input @error('province') has-error @enderror" required>
                        <option value="">— انتخاب کنید —</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province }}" {{ old('province') === $province ? 'selected' : '' }}>{{ $province }}</option>
                        @endforeach
                    </select>
                    @error('province')<p class="wizard-error">{{ $message }}</p>@enderror
                </div>


                <div class="wizard-field">
                    <label for="f-city" class="wizard-label">شهر <span class="wizard-required">*</span></label>
                    <input id="f-city" type="text" name="city" value="{{ old('city') }}" class="wizard-input @error('city') has-error @enderror" required>
                    @error('city')<p class="wizard-error">{{ $message }}</p>@enderror
                </div>


                <div class="wizard-field">
                    <label for="f-address" class="wizard-label">آدرس ساختمان <span class="wizard-required">*</span></label>
                    <textarea id="f-address" name="address" rows="4" class="wizard-input @error('address') has-error @enderror" required>{{ old('address') }}</textarea>
                    <p class="wizard-hint">همون آدرسی که تکنسین باید برای تعمیر بیاد اونجا</p>
                    @error('address')<p class="wizard-error">{{ $message }}</p>@enderror
                </div>


                <div class="wizard-form-actions">
                    <span></span>
                    <button type="submit" class="wizard-btn wizard-btn-primary">ورود به پروسرویس</button>
                </div>


            </form>

        </div>


    </div>

</div>

@endsection
