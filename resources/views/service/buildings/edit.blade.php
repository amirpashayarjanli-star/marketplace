@extends('layouts.app')

@section('title', 'ویرایش ' . $building->title . ' | پرونده')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="service-page-head">
            <div>
                <span class="building-code">{{ $building->code }}</span>
                <h1 class="wizard-title">ویرایش پرونده</h1>
                <p class="wizard-subtitle">دستگاه‌ها از صفحه‌ی پرونده مدیریت می‌شوند.</p>
            </div>
        </div>


        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST" action="{{ route('service.buildings.update', $building) }}"
              class="card building-form">
            @csrf
            @method('PUT')


            <div class="field">
                <label class="field-label" for="title">نام ساختمان</label>
                <input id="title" type="text" name="title" class="input" required
                       value="{{ old('title', $building->title) }}">
            </div>

            <div class="field-row">

                <div class="field">
                    <label class="field-label" for="province">استان</label>
                    <select id="province" name="province" class="input">
                        <option value="">— انتخاب کنید —</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province }}"
                                @selected(old('province', $building->province) === $province)>
                                {{ $province }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label class="field-label" for="city">شهر</label>
                    <input id="city" type="text" name="city" class="input"
                           value="{{ old('city', $building->city) }}">
                </div>

            </div>

            <div class="field">
                <label class="field-label" for="address">آدرس</label>
                <textarea id="address" name="address" rows="2" class="input"
                          required>{{ old('address', $building->address) }}</textarea>
            </div>

            <div class="field-row">

                <div class="field">
                    <label class="field-label" for="postal_code">کد پستی</label>
                    <input id="postal_code" type="text" name="postal_code" class="input"
                           value="{{ old('postal_code', $building->postal_code) }}">
                </div>

                <div class="field">
                    <label class="field-label" for="floors">تعداد طبقات</label>
                    <input id="floors" type="number" name="floors" class="input" min="0"
                           value="{{ old('floors', $building->floors) }}">
                </div>

                <div class="field">
                    <label class="field-label" for="units">تعداد واحدها</label>
                    <input id="units" type="number" name="units" class="input" min="0"
                           value="{{ old('units', $building->units) }}">
                </div>

            </div>

            <div class="field-row">

                <div class="field">
                    <label class="field-label" for="manager_name">نام مدیر ساختمان</label>
                    <input id="manager_name" type="text" name="manager_name" class="input"
                           value="{{ old('manager_name', $building->manager_name) }}">
                </div>

                <div class="field">
                    <label class="field-label" for="manager_mobile">موبایل مدیر ساختمان</label>
                    <input id="manager_mobile" type="tel" name="manager_mobile" class="input"
                           value="{{ old('manager_mobile', $building->manager_mobile) }}">
                </div>

            </div>

            <div class="field">
                <label class="field-label" for="notes">توضیحات</label>
                <textarea id="notes" name="notes" rows="3"
                          class="input">{{ old('notes', $building->notes) }}</textarea>
            </div>


            <div class="building-form-actions">
                <button type="submit" class="btn btn-primary">ذخیره</button>
                <a href="{{ route('service.buildings.show', $building) }}" class="btn btn-ghost">انصراف</a>
            </div>


        </form>


    </div>

</div>

@endsection
