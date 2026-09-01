@extends('layouts.app')

@section('title', 'قرارداد ' . $contract->code)

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        <div class="auction-back">
            <a href="{{ route('admin.contracts.index') }}">← همه‌ی قراردادها</a>
        </div>


        <div class="service-page-head">

            <div>
                <span class="building-code">{{ $contract->code }}</span>
                <h1 class="wizard-title">{{ $contract->building->title }}</h1>
                <p class="wizard-subtitle">
                    {{ $contract->building->customer->name }}
                    @if($contract->building->customer->mobile)
                        — {{ $contract->building->customer->mobile }}
                    @endif
                </p>
            </div>

            <span class="badge @if($contract->isActive()) badge-success @elseif($contract->status === 'cancelled') badge-danger @endif">
                {{ $contract->statusLabel() }}
            </span>

        </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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



        {{-- ---- پرونده ---- --}}

        <section class="card contract-detail">

            <h2 class="building-block-title">پرونده</h2>

            <dl class="contract-facts">

                <div>
                    <dt>شماره پرونده</dt>
                    <dd>{{ $contract->building->code }}</dd>
                </div>

                <div>
                    <dt>آدرس</dt>
                    <dd>{{ $contract->building->fullAddress() ?: '—' }}</dd>
                </div>

                <div>
                    <dt>طبقات / واحدها</dt>
                    <dd>{{ $contract->building->floors ?? '—' }} / {{ $contract->building->units ?? '—' }}</dd>
                </div>

                <div>
                    <dt>مدیر ساختمان</dt>
                    <dd>
                        {{ $contract->building->manager_name ?: '—' }}
                        @if($contract->building->manager_mobile)
                            <small>{{ $contract->building->manager_mobile }}</small>
                        @endif
                    </dd>
                </div>

            </dl>

            <h3 class="building-block-title" style="margin-top:20px;">
                دستگاه‌ها ({{ $contract->building->elevators->count() }})
            </h3>

            <div class="elevator-list">
                @foreach($contract->building->elevators as $elevator)
                    <div class="card elevator-item">
                        <div>
                            <strong>{{ $elevator->label }}</strong>
                            <p class="building-card-meta">{{ $elevator->summary() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </section>



        {{-- ---- قیمت‌گذاری ---- --}}

        @if(in_array($contract->status, ['pending_review', 'awaiting_payment'], true))

            <section class="card contract-detail">

                <h2 class="building-block-title">قیمت‌گذاری</h2>

                <p class="field-hint">
                    {{ $contract->planLabel() }} / {{ $contract->termLabel() }}
                    — {{ $contract->months }} ماه × {{ $contract->elevator_count }} دستگاه
                    @if($contract->discount_percent > 0)
                        — {{ $contract->discount_percent }}٪ تخفیف دوره
                    @endif
                </p>

                <form method="POST" action="{{ route('admin.contracts.quote', $contract) }}"
                      class="building-form" style="padding:0; border:none; background:none;">
                    @csrf

                    <div class="field-row">

                        <div class="field">
                            <label class="field-label" for="monthly_fee">اجاره‌ی ماهانه هر دستگاه (تومان)</label>
                            <input id="monthly_fee" type="number" name="monthly_fee" class="input" min="0"
                                   value="{{ old('monthly_fee', $contract->monthly_fee) }}" required>
                        </div>

                        <div class="field">
                            <label class="field-label" for="admin_note">یادداشت برای مشتری</label>
                            <input id="admin_note" type="text" name="admin_note" class="input"
                                   value="{{ old('admin_note', $contract->admin_note) }}">
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        ثبت قیمت و ارسال برای پرداخت
                    </button>

                </form>

            </section>

        @endif



        {{-- ---- تکنسین ---- --}}

        <section class="card contract-detail">

            <h2 class="building-block-title">تکنسین</h2>

            <p class="field-hint">
                فعلی: {{ $contract->technician?->name ?? $contract->technicianModeLabel() }}
            </p>

            <form method="POST" action="{{ route('admin.contracts.technician', $contract) }}"
                  class="field-row">
                @csrf

                <div class="field">
                    <label class="field-label" for="technician_id">تعیین تکنسین اختصاصی</label>
                    <select id="technician_id" name="technician_id" class="input" required>
                        <option value="">— انتخاب کنید —</option>
                        @foreach($technicians as $technician)
                            <option value="{{ $technician->id }}"
                                @selected($contract->technician_id === $technician->id)>
                                {{ $technician->name }}
                                @if($technician->city) — {{ $technician->city }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-outline">ثبت تکنسین</button>

            </form>

        </section>



        {{-- ---- بیمه‌نامه ---- --}}

        <section class="card contract-detail">

            <h2 class="building-block-title">بیمه‌نامه</h2>

            @forelse($contract->policies as $policy)

                <div class="card policy-card @if($policy->isValid()) is-valid @endif">

                    <div>
                        <strong>{{ $policy->insurer }}</strong>
                        <p class="building-card-meta">شماره: {{ $policy->policy_no }}</p>
                        <p class="building-card-meta">
                            سقف پوشش: {{ number_format($policy->coverage_amount) }} تومان
                            · {{ jdate($policy->starts_at) }} تا {{ jdate($policy->ends_at) }}
                        </p>
                    </div>

                    <form method="POST"
                          action="{{ route('admin.contracts.policies.destroy', [$contract, $policy]) }}"
                          onsubmit="return confirm('این بیمه‌نامه حذف شود؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger-outline">حذف</button>
                    </form>

                </div>

            @empty

                <p class="field-hint">هنوز بیمه‌نامه‌ای برای این قرارداد ثبت نشده است.</p>

            @endforelse


            <details class="elevator-add">

                <summary>ثبت بیمه‌نامه‌ی جدید</summary>

                <form method="POST" action="{{ route('admin.contracts.policies.store', $contract) }}"
                      class="building-form" style="padding:0; border:none; background:none;">
                    @csrf

                    <div class="field-row">

                        <div class="field">
                            <label class="field-label" for="insurer">شرکت بیمه</label>
                            <input id="insurer" type="text" name="insurer" class="input" required
                                   placeholder="مثلاً بیمه ایران">
                        </div>

                        <div class="field">
                            <label class="field-label" for="policy_no">شماره بیمه‌نامه</label>
                            <input id="policy_no" type="text" name="policy_no" class="input" required>
                        </div>

                    </div>

                    <div class="field-row">

                        <div class="field">
                            <label class="field-label" for="coverage_amount">سقف پوشش (تومان)</label>
                            <input id="coverage_amount" type="number" name="coverage_amount"
                                   class="input" min="0" required>
                        </div>

                        <div class="field">
                            <label class="field-label" for="starts_at">تاریخ شروع</label>
                            <input id="starts_at" type="date" name="starts_at" class="input" required>
                        </div>

                        <div class="field">
                            <label class="field-label" for="ends_at">تاریخ پایان</label>
                            <input id="ends_at" type="date" name="ends_at" class="input" required>
                        </div>

                    </div>

                    <div class="field">
                        <label class="field-label" for="policy_notes">توضیحات</label>
                        <input id="policy_notes" type="text" name="notes" class="input">
                    </div>

                    <button type="submit" class="btn btn-primary">ثبت بیمه‌نامه</button>

                </form>

            </details>

        </section>



        {{-- ---- بازدیدهای دوره‌ای ---- --}}

        @if($contract->isPeriodic())

            <section class="card contract-detail">

                <h2 class="building-block-title">
                    بازدیدهای دوره‌ای ({{ $contract->visits->count() }})
                </h2>

                @forelse($contract->visits as $visit)

                    <div class="card visit-item @if($visit->isOverdue()) is-overdue @endif">

                        <div>
                            <strong>{{ jdate($visit->due_on) }}</strong>
                            <p class="building-card-meta">
                                {{ $visit->technician?->name ?? 'تکنسین مشخص نشده' }}
                                @if($visit->report) — {{ $visit->report }} @endif
                            </p>
                        </div>

                        @if($visit->status === 'due')

                            <form method="POST"
                                  action="{{ route('admin.contracts.visits.complete', [$contract, $visit]) }}"
                                  class="visit-item-form">
                                @csrf
                                <input type="text" name="report" class="input" placeholder="گزارش بازدید">
                                <button type="submit" name="status" value="done" class="btn btn-sm btn-success">
                                    انجام شد
                                </button>
                                <button type="submit" name="status" value="missed" class="btn btn-sm btn-danger-outline">
                                    انجام نشد
                                </button>
                            </form>

                        @else

                            <span @class([
                                'badge',
                                'badge-success' => $visit->status === 'done',
                                'badge-danger'  => $visit->status === 'missed',
                            ])>{{ $visit->statusLabel() }}</span>

                        @endif

                    </div>

                @empty

                    <p class="field-hint">
                        برنامه‌ی بازدیدها هنگام فعال‌شدن قرارداد ساخته می‌شود.
                    </p>

                @endforelse

            </section>

        @endif



        {{-- ---- لغو ---- --}}

        @if(! in_array($contract->status, ['cancelled', 'expired'], true))

            <form method="POST" action="{{ route('admin.contracts.cancel', $contract) }}"
                  class="auction-cancel-form"
                  onsubmit="return confirm('قرارداد لغو شود؟')">
                @csrf
                <input type="text" name="reason" class="input" placeholder="دلیل لغو (اختیاری)">
                <button type="submit" class="btn btn-danger-outline">لغو قرارداد</button>
            </form>

        @endif


    </div>

</div>

@endsection
