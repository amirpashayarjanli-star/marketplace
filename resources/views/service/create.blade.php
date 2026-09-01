@extends('layouts.app')

@section('title', 'ثبت خرابی')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro">
            <h1 class="wizard-title">ثبت خرابی جدید</h1>
            <p class="wizard-subtitle">خرابی رو توضیح بدید، به‌زودی فاکتور هزینه براتون صادر می‌شه.</p>
        </div>


        <div class="wizard-form-card">

            <form method="POST" action="{{ route('service.store') }}" class="wizard-form">

                @csrf


                <div class="wizard-field">
                    <label for="f-description" class="wizard-label">شرح خرابی <span class="wizard-required">*</span></label>
                    <textarea id="f-description" name="description" rows="6" class="wizard-input @error('description') has-error @enderror" required>{{ old('description') }}</textarea>
                    <p class="wizard-hint">مثلاً: آسانسور بین طبقه ۲ و ۳ متوقف شده و صدای غیرعادی می‌ده.</p>
                    @error('description')<p class="wizard-error">{{ $message }}</p>@enderror
                </div>


                <div class="wizard-field">
                    <label for="f-address" class="wizard-label">آدرس (اگر با آدرس ثبت‌شده فرق دارد)</label>
                    <textarea id="f-address" name="address" rows="3" class="wizard-input @error('address') has-error @enderror">{{ old('address', $customer->address) }}</textarea>
                    @error('address')<p class="wizard-error">{{ $message }}</p>@enderror
                </div>


                <div class="wizard-form-actions">
                    <a href="{{ route('service.index') }}" class="wizard-btn wizard-btn-ghost">انصراف</a>
                    <button type="submit" class="wizard-btn wizard-btn-primary">ثبت خرابی</button>
                </div>


            </form>

        </div>


    </div>

</div>

@endsection
