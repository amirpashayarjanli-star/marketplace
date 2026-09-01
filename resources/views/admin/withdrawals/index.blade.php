@extends('layouts.app')

@section('title', 'برداشت‌های کیف‌پول')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        @include('admin.partials.nav')


        <div class="service-page-head">
            <div>
                <h1 class="wizard-title">برداشت‌های کیف‌پول</h1>
                <p class="wizard-subtitle">
                    مبلغ هنگام ثبت درخواست از کیف‌پول کاربر کسر شده است. تایید یعنی
                    «واریز کردم»؛ رد کردن مبلغ را به کیف‌پول برمی‌گرداند.
                </p>
            </div>
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


        <div class="auction-tabs">

            <a href="{{ route('admin.withdrawals.index') }}"
               @class(['auction-tab', 'is-active' => ! $currentStatus])>همه</a>

            @foreach($statuses as $key => $label)
                <a href="{{ route('admin.withdrawals.index', ['status' => $key]) }}"
                   @class(['auction-tab', 'is-active' => $currentStatus === $key])>{{ $label }}</a>
            @endforeach

        </div>


        <div class="service-list">

            @forelse($withdrawals as $withdrawal)

                <div class="card withdrawal-item">

                    <div class="withdrawal-item-main">

                        <div class="service-card-head">
                            <span class="service-card-title">
                                {{ number_format($withdrawal->amount) }} تومان
                            </span>
                            <span @class([
                                'badge',
                                'badge-success' => $withdrawal->status === 'approved',
                                'badge-danger'  => $withdrawal->status === 'rejected',
                                'badge-warning' => $withdrawal->status === 'pending',
                            ])>{{ $withdrawal->statusLabel() }}</span>
                        </div>

                        <div class="service-card-meta">
                            {{ $withdrawal->user->name ?: $withdrawal->user->mobile }}
                            ({{ $withdrawal->user->mobile }})
                            · {{ $withdrawal->account_holder }}
                        </div>

                        <div class="service-card-meta">
                            شبا: {{ $withdrawal->iban }}
                            · {{ jdatetime($withdrawal->created_at) }}
                        </div>

                        @if($withdrawal->reference)
                            <div class="service-card-meta">پیگیری: {{ $withdrawal->reference }}</div>
                        @endif

                        @if($withdrawal->admin_note)
                            <div class="service-card-meta">یادداشت: {{ $withdrawal->admin_note }}</div>
                        @endif

                    </div>


                    @if($withdrawal->status === 'pending')

                        <div class="withdrawal-item-actions">

                            <form method="POST"
                                  action="{{ route('admin.withdrawals.approve', $withdrawal) }}"
                                  class="visit-item-form">
                                @csrf
                                <input type="text" name="reference" class="input"
                                       placeholder="شماره پیگیری واریز" required>
                                <button type="submit" class="btn btn-sm btn-success">تایید واریز</button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.withdrawals.reject', $withdrawal) }}"
                                  class="visit-item-form"
                                  onsubmit="return confirm('درخواست رد شود؟ مبلغ به کیف‌پول کاربر برمی‌گردد.')">
                                @csrf
                                <input type="text" name="admin_note" class="input" placeholder="دلیل رد">
                                <button type="submit" class="btn btn-sm btn-danger-outline">رد</button>
                            </form>

                        </div>

                    @endif

                </div>

            @empty

                <p class="auction-blocked">درخواست برداشتی با این فیلتر پیدا نشد.</p>

            @endforelse

        </div>


    </div>

</div>

@endsection
