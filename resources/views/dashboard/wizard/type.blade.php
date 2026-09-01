@extends('layouts.app')

@section('title', 'انتخاب نوع حساب')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro">

            <h1 class="wizard-title">
                نوع حساب خود را انتخاب کنید
            </h1>

            <p class="wizard-subtitle">
                این انتخاب مشخص می‌کند چه اطلاعاتی از شما پرسیده شود و در کدام بخش سایت نمایش داده شوید.
                پس از انتخاب قابل تغییر نیست.
            </p>

        </div>


        @if($errors->any())
            <div class="wizard-alert wizard-alert-error">
                {{ $errors->first() }}
            </div>
        @endif


        <form method="POST"
              action="{{ route('profile.wizard.type.store') }}"
              class="wizard-type-form">

            @csrf


            <div class="wizard-type-grid">

                @foreach($types as $key => $type)

                    <label class="wizard-type-card">

                        <input type="radio"
                               name="type"
                               value="{{ $key }}"
                               {{ old('type') === $key ? 'checked' : '' }}
                               required>

                        <span class="wizard-type-body">

                            <span class="wizard-type-name">
                                {{ $type['label'] }}
                            </span>

                            <span class="wizard-type-meta">
                                {{ count($type['steps']) }} مرحله تکمیل
                            </span>

                        </span>

                    </label>

                @endforeach


                <label class="wizard-type-card wizard-type-card-customer">

                    <input type="radio"
                           name="type"
                           value="customer"
                           {{ old('type') === 'customer' ? 'checked' : '' }}
                           required>

                    <span class="wizard-type-body">

                        <span class="wizard-type-name">
                            مشتری (پروسرویس)
                        </span>

                        <span class="wizard-type-meta">
                            ثبت خرابی آسانسور و درخواست تعمیر
                        </span>

                    </span>

                </label>

            </div>


            <button type="submit" class="wizard-btn wizard-btn-primary">
                ادامه
            </button>


        </form>


    </div>

</div>

@endsection
