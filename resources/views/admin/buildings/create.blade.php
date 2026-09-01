@extends('layouts.app')

@section('title', 'پرونده‌ی جدید | مدیریت')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        @include('admin.partials.nav')


        <div class="service-page-head">
            <div>
                <h1 class="wizard-title">پرونده‌ی جدید</h1>
                <p class="wizard-subtitle">
                    برای مشتری‌ای که تلفنی تماس گرفته و خودش حساب نساخته است.
                </p>
            </div>
        </div>


        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST" action="{{ route('admin.buildings.store') }}"
              class="card building-form"
              x-data="{ elevators: [{}] }">
            @csrf


            <h2 class="building-form-section">مشتری</h2>

            <p class="field-hint">
                اگر این شماره از قبل حساب داشته باشد، پرونده به همان حساب اضافه می‌شود.
                در غیر این صورت حساب مشتری ساخته می‌شود و او می‌تواند با کد پیامکی وارد
                شود و پرونده‌اش را ببیند.
            </p>

            <div class="field-row">

                <div class="field">
                    <label class="field-label" for="customer_mobile">موبایل مشتری</label>
                    <input id="customer_mobile" type="tel" name="customer_mobile" class="input" required
                           value="{{ old('customer_mobile') }}" placeholder="09123456789">
                </div>

                <div class="field">
                    <label class="field-label" for="customer_name">نام مشتری</label>
                    <input id="customer_name" type="text" name="customer_name" class="input" required
                           value="{{ old('customer_name') }}">
                </div>

                <div class="field">
                    <label class="field-label" for="customer_phone">تلفن ثابت (اختیاری)</label>
                    <input id="customer_phone" type="tel" name="customer_phone" class="input"
                           value="{{ old('customer_phone') }}" placeholder="02112345678">
                </div>

            </div>


            <h2 class="building-form-section">مشخصات ساختمان</h2>

            <div class="field">
                <label class="field-label" for="title">نام ساختمان</label>
                <input id="title" type="text" name="title" class="input" required
                       value="{{ old('title') }}" placeholder="مثلاً برج نگین">
            </div>

            <div class="field-row">

                <div class="field">
                    <label class="field-label" for="province">استان</label>
                    @if(!empty($provinces))
                        <select id="province" name="province" class="input">
                            <option value="">— انتخاب کنید —</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province }}" @selected(old('province') === $province)>
                                    {{ $province }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input id="province" type="text" name="province" class="input"
                               value="{{ old('province') }}">
                    @endif
                </div>

                <div class="field">
                    <label class="field-label" for="city">شهر</label>
                    <input id="city" type="text" name="city" class="input" value="{{ old('city') }}">
                </div>

            </div>

            <div class="field">
                <label class="field-label" for="address">آدرس</label>
                <textarea id="address" name="address" rows="2" class="input"
                          required>{{ old('address') }}</textarea>
            </div>

            <div class="field-row">

                <div class="field">
                    <label class="field-label" for="postal_code">کد پستی</label>
                    <input id="postal_code" type="text" name="postal_code" class="input"
                           value="{{ old('postal_code') }}">
                </div>

                <div class="field">
                    <label class="field-label" for="floors">تعداد طبقات</label>
                    <input id="floors" type="number" name="floors" class="input" min="0"
                           value="{{ old('floors') }}">
                </div>

                <div class="field">
                    <label class="field-label" for="units">تعداد واحدها</label>
                    <input id="units" type="number" name="units" class="input" min="0"
                           value="{{ old('units') }}">
                </div>

            </div>

            <div class="field-row">

                <div class="field">
                    <label class="field-label" for="manager_name">نام مدیر ساختمان</label>
                    <input id="manager_name" type="text" name="manager_name" class="input"
                           value="{{ old('manager_name') }}">
                </div>

                <div class="field">
                    <label class="field-label" for="manager_mobile">موبایل مدیر ساختمان</label>
                    <input id="manager_mobile" type="tel" name="manager_mobile" class="input"
                           value="{{ old('manager_mobile') }}" placeholder="09123456789">
                </div>

            </div>


            <h2 class="building-form-section">دستگاه‌های آسانسور</h2>

            <p class="field-hint">
                قیمت قرارداد به تعداد دستگاه‌ها بستگی دارد. اگر مشخصات کامل را ندارید فقط
                نامشان را بنویسید؛ بعداً از داخل پرونده کاملش کنید.
            </p>


            <template x-for="(elevator, i) in elevators" :key="i">

                <div class="elevator-row">

                    <div class="field">
                        <label class="field-label">نام دستگاه</label>
                        <input type="text" class="input"
                               :name="`elevators[${i}][label]`"
                               :placeholder="`آسانسور ${i + 1}`">
                    </div>

                    <div class="field">
                        <label class="field-label">برند</label>
                        <input type="text" class="input" :name="`elevators[${i}][brand]`">
                    </div>

                    <div class="field">
                        <label class="field-label">ظرفیت (kg)</label>
                        <input type="number" class="input" min="0" :name="`elevators[${i}][capacity_kg]`">
                    </div>

                    <div class="field">
                        <label class="field-label">توقف</label>
                        <input type="number" class="input" min="0" :name="`elevators[${i}][stops]`">
                    </div>

                    <button type="button" class="btn btn-sm btn-danger-outline elevator-row-remove"
                            x-show="elevators.length > 1"
                            x-on:click="elevators.splice(i, 1)">
                        حذف
                    </button>

                </div>

            </template>


            <button type="button" class="btn btn-sm btn-outline"
                    x-on:click="elevators.push({})">
                افزودن دستگاه
            </button>


            <div class="field">
                <label class="field-label" for="notes">توضیحات (اختیاری)</label>
                <textarea id="notes" name="notes" rows="3" class="input">{{ old('notes') }}</textarea>
            </div>


            <div class="building-form-actions">
                <button type="submit" class="btn btn-primary">ثبت پرونده</button>
                <a href="{{ route('admin.contracts.index') }}" class="btn btn-ghost">انصراف</a>
            </div>


        </form>


    </div>

</div>

@endsection
