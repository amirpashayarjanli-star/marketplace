@extends('layouts.app')

@section('title', 'تایید کاربران')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        @include('admin.partials.nav')


        <div class="wizard-intro">

            <h1 class="wizard-title">
                کاربران در انتظار تایید
            </h1>

            <p class="wizard-subtitle">
                این کاربران پروفایل خود را کامل کرده‌اند. تا زمانی که تایید نکنید، در سایت نمایش داده نمی‌شوند.
            </p>

        </div>


        @if(session('success'))
            <div class="wizard-alert wizard-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="wizard-alert wizard-alert-error">
                {{ session('error') }}
            </div>
        @endif


        @forelse($users as $user)

            @php
                $wizard = \App\Services\ProfileWizard::for($user);
                $profile = $wizard->profile();
                $definition = $wizard->definition();
            @endphp


            <div class="wizard-form-card">


                <div class="flex items-start justify-between gap-4 mb-5">

                    <div>

                        <h3 class="text-xl font-black text-slate-900">
                            {{ $profile->name ?? $user->name }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            {{ $definition['label'] ?? '—' }}
                            ·
                            ثبت‌نام: {{ $user->created_at?->format('Y/m/d') }}
                        </p>

                    </div>


                    <div class="flex gap-2 flex-none">

                        <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                            @csrf
                            <button class="wizard-btn wizard-btn-primary" style="padding:10px 20px">
                                تایید
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                            @csrf
                            <button class="wizard-btn wizard-btn-ghost" style="padding:10px 20px">
                                رد
                            </button>
                        </form>

                    </div>

                </div>


                @if($profile)

                    <div class="grid gap-x-6 gap-y-3 md:grid-cols-2 text-sm">

                        @foreach($wizard->steps() as $stepKey => $step)

                            @foreach($step['fields'] as $fieldName => $field)

                                @php $value = $profile->{$fieldName}; @endphp

                                <div class="flex gap-2 border-b border-slate-100 pb-2">

                                    <span class="text-slate-500 flex-none">{{ $field['label'] }}:</span>

                                    <span class="text-slate-900 font-medium break-all">

                                        @if($field['type'] === 'image')

                                            @if($value)
                                                <a href="{{ asset('storage/' . $value) }}"
                                                   target="_blank"
                                                   class="text-blue-600 underline">مشاهده تصویر</a>
                                            @else
                                                <span class="text-red-600">ندارد</span>
                                            @endif

                                        @elseif(filled($value))

                                            {{ $value }}

                                        @else

                                            <span class="text-red-600">خالی</span>

                                        @endif

                                    </span>

                                </div>

                            @endforeach

                        @endforeach

                    </div>

                @else

                    <p class="text-red-600 text-sm">
                        این کاربر هنوز پروفایلی نساخته است.
                    </p>

                @endif


            </div>

        @empty

            <div class="wizard-form-card text-center">
                <p class="text-slate-500">
                    در حال حاضر کاربری در انتظار تایید نیست.
                </p>
            </div>

        @endforelse


    </div>

</div>

@endsection
