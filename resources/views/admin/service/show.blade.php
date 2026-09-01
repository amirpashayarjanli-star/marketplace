@extends('layouts.app')

@section('title', 'خرابی #' . $serviceRequest->id)

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:760px">


        <div class="wizard-intro" style="text-align:start; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">

            <div>
                <h1 class="wizard-title" style="margin-bottom:4px;">خرابی #{{ $serviceRequest->id }}</h1>
                <p class="wizard-subtitle">{{ $serviceRequest->customer->name }} — {{ jdatetime($serviceRequest->created_at) }}</p>
            </div>

            <span class="service-status service-status-{{ $serviceRequest->status }}" style="font-size:.9rem; padding:8px 18px;">
                {{ $serviceRequest->label() }}
            </span>

        </div>


        @if(session('success'))
            <div class="wizard-alert wizard-alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="wizard-alert wizard-alert-error">{{ session('error') }}</div>
        @endif


        {{-- اطلاعات مشتری و خرابی --}}

        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:10px;">شرح خرابی</h3>
            <p style="color:var(--text); line-height:1.9;">{{ $serviceRequest->description }}</p>

            <div style="margin-top:14px; font-size:.85rem; color:var(--text-muted); display:flex; flex-direction:column; gap:4px;">
                <span>👤 {{ $serviceRequest->customer->name }} · {{ $serviceRequest->customer->mobile }}</span>
                <span>📍 {{ $serviceRequest->address ?: $serviceRequest->customer->address }}</span>
            </div>

        </div>


        {{-- تخصیص تکنسین --}}

        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:14px;">تکنسین</h3>

            <form method="POST" action="{{ route('admin.service.technician', $serviceRequest) }}" class="wizard-form" style="flex-direction:row; gap:10px; align-items:flex-end;">

                @csrf

                <div class="wizard-field" style="flex:1; margin-bottom:0;">
                    <select name="technician_id" class="wizard-input" required>
                        <option value="">— انتخاب تکنسین —</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ $serviceRequest->technician_id === $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }} ({{ $tech->city }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="wizard-btn wizard-btn-primary" style="flex:none;">ثبت</button>

            </form>

        </div>


        {{-- فرم فاکتور --}}

        @php
            $existingItems = $serviceRequest->invoice
                ? $serviceRequest->invoice->items->map(fn($i) => ['title' => $i->title, 'amount' => $i->amount])->values()->toArray()
                : [];

            if (empty($existingItems)) {
                $existingItems = [['title' => '', 'amount' => '']];
            }
        @endphp

        <div class="wizard-form-card"
             x-data="{
                items: {{ json_encode($existingItems) }},
                addItem() { this.items.push({title: '', amount: ''}) },
                removeItem(i) { if (this.items.length > 1) this.items.splice(i, 1) }
             }">

            <h3 class="wizard-progress-label" style="margin-bottom:14px;">فاکتور</h3>

            @if($serviceRequest->status === 'confirmed')

                <p class="wizard-hint">این خرابی تسویه شده و فاکتورش دیگر قابل ویرایش نیست.</p>

            @else

                <form method="POST" action="{{ route('admin.service.invoice', $serviceRequest) }}" class="wizard-form">

                    @csrf

                    <template x-for="(item, index) in items" :key="index">

                        <div class="service-item-row">

                            <input type="text" :name="'items[' + index + '][title]'" x-model="item.title"
                                   placeholder="شرح (مثلاً: تعویض موتور درب)" class="wizard-input" required>

                            <input type="number" :name="'items[' + index + '][amount]'" x-model="item.amount"
                                   placeholder="مبلغ (تومان)" class="wizard-input" style="max-width:160px;" min="0" required>

                            <button type="button" class="service-item-remove" @click="removeItem(index)">✕</button>

                        </div>

                    </template>

                    <button type="button" class="wizard-btn wizard-btn-ghost" @click="addItem()" style="margin-bottom:20px;">
                        + افزودن ردیف
                    </button>


                    <div class="wizard-field">
                        <label class="wizard-label">درصد کمیسیون پلتفرم</label>
                        <input type="number" name="commission_percent" class="wizard-input"
                               value="{{ old('commission_percent', $serviceRequest->invoice->commission_percent ?? 15) }}"
                               min="0" max="100" required>
                    </div>


                    <label style="display:flex; align-items:center; gap:8px; font-size:.9rem; color:var(--text); margin-bottom:10px;">
                        <input type="checkbox" name="has_insurance" value="1" {{ $serviceRequest->has_insurance ? 'checked' : '' }}>
                        این خرابی تحت پوشش بیمه است
                    </label>


                    <div class="wizard-form-actions">
                        <span></span>
                        <button type="submit" class="wizard-btn wizard-btn-primary">
                            {{ $serviceRequest->invoice ? 'به‌روزرسانی فاکتور' : 'صدور فاکتور' }}
                        </button>
                    </div>

                </form>

            @endif

        </div>


        {{-- خلاصه‌ی مالی --}}

        @if($serviceRequest->invoice)

            <div class="wizard-form-card">

                <h3 class="wizard-progress-label" style="margin-bottom:10px;">خلاصه‌ی مالی</h3>

                <table class="service-invoice-table">
                    <tr><td>جمع فاکتور</td><td>{{ number_format($serviceRequest->invoice->subtotal) }} تومان</td></tr>
                    <tr><td>سهم پلتفرم ({{ $serviceRequest->invoice->commission_percent }}٪)</td><td>{{ number_format($serviceRequest->invoice->commission_amount) }} تومان</td></tr>
                    <tr class="service-invoice-total-row"><td>سهم تکنسین</td><td>{{ number_format($serviceRequest->invoice->technician_amount) }} تومان</td></tr>
                </table>

                @if($serviceRequest->invoice->paid_at)
                    <p class="wizard-hint" style="margin-top:10px;">تسویه‌شده در {{ jdatetime($serviceRequest->invoice->paid_at) }}</p>
                @endif

            </div>

        @endif


        {{-- لغو --}}

        @if(!in_array($serviceRequest->status, ['confirmed', 'cancelled']))

            <form method="POST" action="{{ route('admin.service.cancel', $serviceRequest) }}"
                  onsubmit="return confirm('این خرابی لغو شود؟');">
                @csrf
                <button type="submit" class="wizard-btn wizard-btn-ghost" style="color:var(--danger); border-color:var(--pastel-danger-border);">
                    لغو این خرابی
                </button>
            </form>

        @endif


        {{-- تایم‌لاین --}}

        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:14px;">مراحل</h3>

            <div class="service-timeline">
                @foreach($serviceRequest->statusLogs as $log)
                    <div class="service-timeline-item">
                        <div class="service-timeline-label">{{ \App\Models\ServiceRequest::LABELS[$log->status] ?? $log->status }}</div>
                        @if($log->note)
                            <div class="service-timeline-time">{{ $log->note }}</div>
                        @endif
                        <div class="service-timeline-time">{{ jdatetime($log->created_at) }}</div>
                    </div>
                @endforeach
            </div>

        </div>


    </div>

</div>

@endsection
