@extends('layouts.app')

@section('title', $step['title'])

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        {{-- نوار مراحل --}}

        <div class="wizard-rail">

            @foreach($stepKeys as $i => $key)

                <a href="{{ route('profile.wizard.step', $key) }}"
                   class="wizard-rail-item
                          {{ $statuses[$key] ? 'is-done' : '' }}
                          {{ $key === $stepKey ? 'is-current' : '' }}"
                   title="{{ $wizard->step($key)['title'] }}">

                    <span class="wizard-rail-mark">
                        {{ $statuses[$key] ? '✓' : $i + 1 }}
                    </span>

                </a>

            @endforeach

        </div>


        <div class="wizard-form-card">


            <div class="wizard-form-head">

                <h1 class="wizard-title">
                    {{ $step['title'] }}
                </h1>

                <p class="wizard-subtitle">
                    همه‌ی فیلدها باید توسط شما پر شوند. هیچ مقداری به‌صورت خودکار تکمیل نمی‌شود.
                </p>

            </div>


            @if($errors->any())

                <div class="wizard-alert wizard-alert-error">

                    <strong>لطفاً موارد زیر را اصلاح کنید:</strong>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif

            @if(session('success'))
                <div class="wizard-alert wizard-alert-success">
                    {{ session('success') }}
                </div>
            @endif


            <form method="POST"
                  action="{{ route('profile.wizard.step.store', $stepKey) }}"
                  enctype="multipart/form-data"
                  class="wizard-form">

                @csrf


                @foreach($step['fields'] as $name => $field)

                    @php
                        $current = old($name, $profile->{$name} ?? null);
                        $isOptional = ! empty($field['optional']);
                    @endphp


                    <div class="wizard-field">

                        <label for="f-{{ $name }}" class="wizard-label">

                            {{ $field['label'] }}

                            @if($isOptional)
                                <span class="wizard-optional">اختیاری</span>
                            @else
                                <span class="wizard-required">*</span>
                            @endif

                        </label>


                        @switch($field['type'])


                            @case('textarea')

                                <textarea id="f-{{ $name }}"
                                          name="{{ $name }}"
                                          rows="5"
                                          class="wizard-input @error($name) has-error @enderror"
                                          {{ $isOptional ? '' : 'required' }}>{{ $current }}</textarea>

                                @break


                            @case('province')

                                <select id="f-{{ $name }}"
                                        name="{{ $name }}"
                                        class="wizard-input @error($name) has-error @enderror"
                                        {{ $isOptional ? '' : 'required' }}>

                                    <option value="">— انتخاب کنید —</option>

                                    @foreach($provinces as $province)
                                        <option value="{{ $province }}"
                                                {{ $current === $province ? 'selected' : '' }}>
                                            {{ $province }}
                                        </option>
                                    @endforeach

                                </select>

                                @break


                            @case('image')

                                @if($current)
                                    <div class="wizard-image-current">
                                        <img src="{{ asset('storage/' . $current) }}" alt="{{ $field['label'] }}">
                                        <span>تصویر فعلی — برای تغییر، فایل جدید انتخاب کنید</span>
                                    </div>
                                @endif

                                <input id="f-{{ $name }}"
                                       type="file"
                                       name="{{ $name }}"
                                       accept="image/*"
                                       class="wizard-input wizard-file @error($name) has-error @enderror"
                                       {{ $current ? '' : 'required' }}>

                                @break


                            @case('tags')

                                <input id="f-{{ $name }}"
                                       type="text"
                                       name="{{ $name }}"
                                       value="{{ $current }}"
                                       class="wizard-input @error($name) has-error @enderror"
                                       {{ $isOptional ? '' : 'required' }}>

                                @break


                            @default

                                <input id="f-{{ $name }}"
                                       type="{{ $field['type'] }}"
                                       name="{{ $name }}"
                                       value="{{ $current }}"
                                       class="wizard-input @error($name) has-error @enderror"
                                       @if($field['type'] === 'tel') inputmode="numeric" dir="ltr" @endif
                                       @if($field['type'] === 'url') dir="ltr" placeholder="https://" @endif
                                       @if($field['type'] === 'email') dir="ltr" @endif
                                       {{ $isOptional ? '' : 'required' }}>


                        @endswitch


                        @if(! empty($field['hint']))
                            <p class="wizard-hint">{{ $field['hint'] }}</p>
                        @endif

                        @error($name)
                            <p class="wizard-error">{{ $message }}</p>
                        @enderror

                    </div>

                @endforeach


                <div class="wizard-form-actions">

                    <a href="{{ route('profile.wizard') }}" class="wizard-btn wizard-btn-ghost">
                        بازگشت به فهرست مراحل
                    </a>

                    <button type="submit" class="wizard-btn wizard-btn-primary">
                        ذخیره و ادامه
                    </button>

                </div>


            </form>


        </div>


    </div>

</div>

@endsection
