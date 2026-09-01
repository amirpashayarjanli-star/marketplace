@extends('layouts.app')

@section('title', 'قرارداد سرویس | ' . $building->title)

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        @include('admin.partials.nav')


        <div class="service-page-head">
            <div>
                <span class="building-code">{{ $building->code }}</span>
                <h1 class="wizard-title">قرارداد سرویس برای «{{ $building->title }}»</h1>
                <p class="wizard-subtitle">
                    مشتری: {{ $building->customer->name }}
                    @if($building->customer->mobile)
                        — {{ $building->customer->mobile }}
                    @endif
                    · {{ $elevatorCount }} دستگاه آسانسور
                </p>
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


        <form method="POST" action="{{ route('admin.buildings.contract.store', $building) }}"
              x-data="{
                  plan: '{{ old('plan', 'periodic') }}',
                  term: '{{ old('term', 'yearly') }}',
                  mode: '{{ old('technician_mode', 'assigned') }}',
                  quotes: {{ Js::from($quotes) }},
                  get total(){ return (this.quotes[this.plan] || {})[this.term] || 0 },
                  get totalFa(){ return this.total.toLocaleString('fa-IR') }
              }">
            @csrf


            {{-- ---- گام ۱: طرح ---- --}}

            <h2 class="building-form-section">۱. طرح سرویس</h2>

            <div class="plan-grid">

                @foreach($plans as $key => $plan)

                    <label class="plan-card">

                        <input type="radio" name="plan" value="{{ $key }}" x-model="plan">

                        <span class="plan-card-body">
                            <strong>{{ $plan['label'] }}</strong>
                            <span class="plan-card-desc">{{ $plan['description'] }}</span>

                            @if($plan['visits_per_month'] > 0)
                                <span class="badge badge-success">
                                    {{ $plan['visits_per_month'] }} بازدید در ماه
                                </span>
                            @else
                                <span class="badge">بدون بازدید دوره‌ای</span>
                            @endif
                        </span>

                    </label>

                @endforeach

            </div>


            {{-- ---- گام ۲: دوره ---- --}}

            <h2 class="building-form-section">۲. مدت قرارداد</h2>

            <div class="plan-grid plan-grid-terms">

                @foreach($terms as $key => $term)

                    <label class="plan-card">

                        <input type="radio" name="term" value="{{ $key }}" x-model="term">

                        <span class="plan-card-body">
                            <strong>{{ $term['label'] }}</strong>

                            @if($term['discount_percent'] > 0)
                                <span class="badge badge-gold">{{ $term['discount_percent'] }}٪ تخفیف</span>
                            @endif

                            <span class="plan-card-price"
                                  x-text="((quotes[plan] || {})['{{ $key }}'] || 0).toLocaleString('fa-IR') + ' تومان'"></span>
                        </span>

                    </label>

                @endforeach

            </div>


            {{-- ---- گام ۳: تکنسین ---- --}}

            <h2 class="building-form-section">۳. تکنسین</h2>

            <div class="plan-grid">

                @foreach($modes as $key => $label)

                    <label class="plan-card">

                        <input type="radio" name="technician_mode" value="{{ $key }}" x-model="mode">

                        <span class="plan-card-body">
                            <strong>{{ $label }}</strong>

                            <span class="plan-card-desc">
                                @switch($key)
                                    @case('dedicated')
                                        یک تکنسین ثابت روی قرارداد ثبت می‌شود و همه‌ی کارهای این ساختمان به او می‌رود.
                                        @break
                                    @case('assigned')
                                        برای هر کار، تکنسین را ما تعیین می‌کنیم.
                                        @break
                                    @default
                                        مشتری هر بار خودش از فهرست تکنسین‌ها انتخاب می‌کند.
                                @endswitch
                            </span>
                        </span>

                    </label>

                @endforeach

            </div>


            <div class="field" x-show="mode === 'dedicated'" x-cloak>

                <label class="field-label" for="technician_id">انتخاب تکنسین اختصاصی</label>

                <select id="technician_id" name="technician_id" class="input">
                    <option value="">— انتخاب کنید —</option>
                    @foreach($technicians as $technician)
                        <option value="{{ $technician->id }}" @selected(old('technician_id') == $technician->id)>
                            {{ $technician->name }}
                            @if($technician->city) — {{ $technician->city }} @endif
                            — امتیاز {{ number_format((float) $technician->rating, 1) }}
                            ({{ $technician->reviews_count }} نظر)
                        </option>
                    @endforeach
                </select>

                <p class="field-hint">
                    تکنسین‌های هم‌شهر ساختمان اول فهرست‌اند و ترتیب بر اساس امتیاز کاربران است.
                </p>

            </div>


            {{-- ---- جمع‌بندی ---- --}}

            <div class="card contract-total">

                <div>
                    <p class="contract-total-label">برآورد اولیه</p>
                    <p class="contract-total-amount"><span x-text="totalFa"></span> تومان</p>
                    <p class="field-hint">
                        قرارداد در وضعیت «در انتظار بررسی» ثبت می‌شود. قیمت نهایی را از صفحه‌ی
                        قرارداد بگذارید تا برای پرداخت به مشتری برود.
                    </p>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">ثبت قرارداد</button>

            </div>


        </form>


    </div>

</div>

@endsection
