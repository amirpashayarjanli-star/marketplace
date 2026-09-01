@extends('layouts.app')

@section('title', 'ثبت خرابی')

@section('content')

@php
    // پرونده‌ای که از صفحه‌ی خود پرونده آمده، پیش‌فرض انتخاب می‌شود.
    $selectedBuilding = old('building_id', request('building'));
@endphp

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro">
            <h1 class="wizard-title">ثبت خرابی جدید</h1>
            <p class="wizard-subtitle">خرابی رو توضیح بدید، به‌زودی فاکتور هزینه براتون صادر می‌شه.</p>
        </div>


        <div class="wizard-form-card">

            <form method="POST" action="{{ route('service.store') }}" class="wizard-form"
                  x-data="{
                      buildingId: '{{ $selectedBuilding }}',
                      buildings: {{ Js::from($buildings->mapWithKeys(fn ($b) => [
                          $b->id => [
                              'address'   => $b->fullAddress(),
                              'covered'   => (bool) $b->activeContract?->isPeriodic(),
                              'elevators' => $b->elevators->map(fn ($e) => ['id' => $e->id, 'label' => $e->label])->values(),
                          ],
                      ])) }},
                      get current(){ return this.buildings[this.buildingId] || null }
                  }">

                @csrf


                @if($buildings->isNotEmpty())

                    <div class="wizard-field">

                        <label for="f-building" class="wizard-label">پرونده‌ی ساختمان</label>

                        <select id="f-building" name="building_id" class="wizard-input" x-model="buildingId">
                            <option value="">— بدون پرونده —</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}">
                                    {{ $building->title }} ({{ $building->code }})
                                </option>
                            @endforeach
                        </select>

                        <p class="wizard-hint">
                            ثبت خرابی زیر یک پرونده باعث می‌شود تاریخچه‌ی ساختمان کامل بماند و
                            اگر قرارداد دوره‌ای فعال داشته باشد، هزینه‌ای از شما گرفته نشود.
                        </p>

                    </div>


                    <div class="wizard-field" x-show="current && current.elevators.length > 1" x-cloak>

                        <label for="f-elevator" class="wizard-label">کدام دستگاه؟</label>

                        <select id="f-elevator" name="elevator_id" class="wizard-input">
                            <option value="">— مشخص نیست —</option>
                            <template x-for="e in (current ? current.elevators : [])" :key="e.id">
                                <option :value="e.id" x-text="e.label"></option>
                            </template>
                        </select>

                    </div>


                    <div class="wizard-status wizard-status-approved"
                         x-show="current && current.covered" x-cloak>
                        <strong>این ساختمان قرارداد سرویس دوره‌ای فعال دارد</strong>
                        <span>خرابی‌های معمول تحت پوشش قرارداد است و فاکتور جداگانه ندارد.</span>
                    </div>

                @else

                    <div class="wizard-status wizard-status-incomplete">
                        <strong>هنوز پرونده‌ای نساخته‌اید</strong>
                        <span>
                            می‌توانید بدون پرونده هم خرابی ثبت کنید، ولی با ساخت پرونده
                            تاریخچه، قرارداد و بیمه‌ی ساختمانتان یک‌جا جمع می‌شود.
                            <a href="{{ route('service.buildings.create') }}">ساخت پرونده</a>
                        </span>
                    </div>

                @endif


                <div class="wizard-field">
                    <label for="f-description" class="wizard-label">شرح خرابی <span class="wizard-required">*</span></label>
                    <textarea id="f-description" name="description" rows="6" class="wizard-input @error('description') has-error @enderror" required>{{ old('description') }}</textarea>
                    <p class="wizard-hint">مثلاً: آسانسور بین طبقه ۲ و ۳ متوقف شده و صدای غیرعادی می‌ده.</p>
                    @error('description')<p class="wizard-error">{{ $message }}</p>@enderror
                </div>


                <div class="wizard-field">
                    <label for="f-address" class="wizard-label">آدرس (اگر با آدرس ثبت‌شده فرق دارد)</label>
                    <textarea id="f-address" name="address" rows="3" class="wizard-input @error('address') has-error @enderror"
                              x-bind:placeholder="current ? current.address : ''">{{ old('address') }}</textarea>
                    <p class="wizard-hint">خالی بگذارید تا آدرس پرونده استفاده شود.</p>
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
