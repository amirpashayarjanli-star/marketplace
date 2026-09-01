@extends('layouts.app')

@section('title', 'کیف پول')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell">


        <div class="wizard-intro" style="text-align:start;">
            <h1 class="wizard-title">کیف پول</h1>
        </div>


        @if(session('success'))
            <div class="wizard-form-card" style="border-color:var(--success);color:var(--pastel-success-text);">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="wizard-form-card" style="border-color:var(--danger);color:var(--pastel-danger-text);">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="wizard-form-card" style="border-color:var(--danger);color:var(--pastel-danger-text);">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif


        <div class="wallet-balance-card">
            <div class="wallet-balance-label">موجودی فعلی</div>
            <div class="wallet-balance-amount">{{ number_format($wallet->balance) }} تومان</div>
        </div>


        {{-- شارژ کیف‌پول --}}

        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:10px;">افزایش موجودی</h3>

            @if($gatewayEnabled)

                <form method="POST" action="{{ route('wallet.topup') }}">
                    @csrf

                    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;">
                        @foreach([500000, 1000000, 2000000, 5000000] as $preset)
                            <button type="button"
                                    class="wallet-preset-btn"
                                    data-amount="{{ $preset }}">
                                {{ number_format($preset) }}
                            </button>
                        @endforeach
                    </div>

                    <label class="wizard-label" for="wallet-amount">مبلغ (تومان)</label>
                    <input type="number"
                           id="wallet-amount"
                           name="amount"
                           class="wizard-input"
                           required
                           min="{{ $minAmount }}"
                           max="{{ $maxAmount }}"
                           value="{{ old('amount') }}"
                           placeholder="مثلاً {{ number_format($minAmount) }}">

                    <p class="wizard-subtitle" style="margin-top:8px;">
                        حداقل {{ number_format($minAmount) }} تومان.
                        پرداخت از طریق درگاه امن زرین‌پال انجام می‌شود.
                    </p>

                    <button type="submit" class="wizard-btn wizard-btn-primary" style="margin-top:12px;">
                        پرداخت و شارژ
                    </button>

                </form>


                <script>
                    document.querySelectorAll('.wallet-preset-btn').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            document.getElementById('wallet-amount').value = btn.dataset.amount;
                        });
                    });
                </script>

            @else

                <p class="wizard-subtitle">
                    درگاه پرداخت هنوز فعال نشده است. برای شارژ کیف‌پول با پشتیبانی تماس بگیرید.
                </p>

            @endif

        </div>


        {{-- ---- برداشت ---- --}}

        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:6px;">برداشت از کیف‌پول</h3>

            <p class="field-hint">
                مبلغ همان لحظه‌ی ثبت درخواست از موجودی کسر می‌شود و پس از بررسی
                به شبای شما واریز می‌گردد. اگر درخواست رد شود مبلغ برمی‌گردد.
            </p>

            <form method="POST" action="{{ route('wallet.withdraw') }}" class="building-form"
                  style="padding:0; border:none; background:none; gap:14px;">
                @csrf

                <div class="field-row">

                    <div class="field">
                        <label class="field-label" for="w-amount">مبلغ (تومان)</label>
                        <input id="w-amount" type="number" name="amount" class="input"
                               min="{{ $minWithdrawal }}" max="{{ $wallet->balance }}" required
                               placeholder="حداقل {{ number_format($minWithdrawal) }}">
                    </div>

                    <div class="field">
                        <label class="field-label" for="w-holder">نام صاحب حساب</label>
                        <input id="w-holder" type="text" name="account_holder" class="input" required>
                    </div>

                </div>

                <div class="field">
                    <label class="field-label" for="w-iban">شماره شبا</label>
                    <input id="w-iban" type="text" name="iban" class="input" required
                           placeholder="IR000000000000000000000000"
                           pattern="IR[0-9]{24}">
                    <p class="field-hint">با IR شروع شود و ۲۴ رقم داشته باشد.</p>
                </div>

                <button type="submit" class="btn btn-primary"
                        @disabled($wallet->balance < $minWithdrawal)>
                    ثبت درخواست برداشت
                </button>

            </form>


            @if($withdrawals->isNotEmpty())

                <h4 class="wizard-progress-label" style="margin:22px 0 8px;">درخواست‌های اخیر</h4>

                <div class="service-list">
                    @foreach($withdrawals as $withdrawal)
                        <div class="card elevator-item">
                            <div>
                                <strong>{{ number_format($withdrawal->amount) }} تومان</strong>
                                <p class="building-card-meta">
                                    {{ $withdrawal->iban }} · {{ jdatetime($withdrawal->created_at) }}
                                </p>
                                @if($withdrawal->reference)
                                    <p class="building-card-meta">پیگیری: {{ $withdrawal->reference }}</p>
                                @endif
                                @if($withdrawal->admin_note)
                                    <p class="building-card-meta">{{ $withdrawal->admin_note }}</p>
                                @endif
                            </div>
                            <span @class([
                                'badge',
                                'badge-success' => $withdrawal->status === 'approved',
                                'badge-danger'  => $withdrawal->status === 'rejected',
                                'badge-warning' => $withdrawal->status === 'pending',
                            ])>{{ $withdrawal->statusLabel() }}</span>
                        </div>
                    @endforeach
                </div>

            @endif

        </div>


        <div class="wizard-form-card">

            <h3 class="wizard-progress-label" style="margin-bottom:6px;">تراکنش‌ها</h3>

            @forelse($wallet->transactions as $tx)

                <div class="wallet-tx-row">

                    <div>
                        <div class="wallet-tx-desc">{{ $tx->description }}</div>
                        <div class="wallet-tx-time">{{ jdatetime($tx->created_at) }}</div>
                    </div>

                    <div class="wallet-tx-amount {{ $tx->type === 'credit' ? 'is-credit' : 'is-debit' }}">
                        {{ $tx->type === 'credit' ? '+' : '−' }}{{ number_format($tx->amount) }}
                    </div>

                </div>

            @empty

                <p class="wizard-subtitle">هنوز تراکنشی ثبت نشده.</p>

            @endforelse

        </div>


    </div>

</div>

@endsection
