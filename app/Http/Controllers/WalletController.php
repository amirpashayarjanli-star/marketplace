<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletPayment;
use App\Models\WalletWithdrawal;
use App\Services\ZarinpalService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    public function __construct(
        protected ZarinpalService $zarinpal,
    ) {}




    public function show()
    {
        $user = Auth::user();

        $wallet = Wallet::forUser($user);
        $wallet->load('transactions.serviceRequest');

        return view('service.wallet', [
            'wallet'         => $wallet,
            'gatewayEnabled' => $this->zarinpal->isEnabled(),
            'minAmount'      => (int) config('services.zarinpal.min_amount', 10000),
            'maxAmount'      => (int) config('services.zarinpal.max_amount', 500000000),
            'withdrawals'    => WalletWithdrawal::where('user_id', $user->id)
                ->latest()
                ->limit(10)
                ->get(),
            'minWithdrawal'  => (int) config('services.wallet.min_withdrawal', 100000),
        ]);
    }




    /*
    |--------------------------------------------------------------------------
    | شروع شارژ — ساخت رکورد پرداخت و رفتن به درگاه
    |--------------------------------------------------------------------------
    */

    public function topUp(Request $request)
    {

        $min = (int) config('services.zarinpal.min_amount', 10000);
        $max = (int) config('services.zarinpal.max_amount', 500000000);

        $data = $request->validate([
            'amount' => "required|integer|min:{$min}|max:{$max}",
        ], [], ['amount' => 'مبلغ']);

        if (! $this->zarinpal->isEnabled()) {
            return back()->with('error', 'درگاه پرداخت هنوز فعال نشده است.');
        }

        $user = Auth::user();

        $payment = WalletPayment::create([
            'user_id' => $user->id,
            'amount'  => $data['amount'],
            'gateway' => 'zarinpal',
            'status'  => 'pending',
        ]);

        $result = $this->zarinpal->request(
            $payment->amount,
            route('wallet.callback'),
            'شارژ کیف‌پول آسانسور پرو',
            $user->mobile,
        );

        if (! $result['ok']) {

            $payment->update([
                'status'  => 'failed',
                'message' => $result['message'] ?? null,
            ]);

            return back()->with('error', $result['message'] ?? 'اتصال به درگاه ممکن نشد.');
        }

        $payment->update(['authority' => $result['authority']]);

        return redirect()->away($this->zarinpal->startUrl($result['authority']));
    }




    /*
    |--------------------------------------------------------------------------
    | بازگشت از درگاه
    |--------------------------------------------------------------------------
    |
    | authority در جدول یکتاست و شارژ فقط وقتی انجام می‌شود که رکورد هنوز
    | pending باشد — پس باز کردن دوباره‌ی لینک بازگشت، کیف‌پول را دو بار
    | شارژ نمی‌کند.
    |
    */

    public function callback(Request $request)
    {

        $authority = (string) $request->query('Authority', '');
        $status    = (string) $request->query('Status', '');

        $payment = WalletPayment::where('authority', $authority)->first();

        if (! $payment) {
            return redirect()->route('wallet')->with('error', 'پرداخت پیدا نشد.');
        }

        // کاربر از درگاه انصراف داده
        if ($status !== 'OK') {

            if ($payment->status === 'pending') {
                $payment->update(['status' => 'canceled', 'message' => 'انصراف کاربر']);
            }

            return redirect()->route('wallet')->with('error', 'پرداخت لغو شد.');
        }

        if ($payment->isPaid()) {
            return redirect()->route('wallet')->with('success', 'این پرداخت قبلاً ثبت شده است.');
        }

        $result = $this->zarinpal->verify($payment->amount, $authority);

        if (! $result['ok']) {

            $payment->update([
                'status'  => 'failed',
                'message' => $result['message'] ?? null,
            ]);

            return redirect()->route('wallet')
                ->with('error', $result['message'] ?? 'پرداخت تایید نشد.');
        }

        DB::transaction(function () use ($payment, $result) {

            // قفل ردیف تا دو callback هم‌زمان دو بار شارژ نکنند
            $locked = WalletPayment::whereKey($payment->id)->lockForUpdate()->first();

            if ($locked->status === 'paid') {
                return;
            }

            $tx = Wallet::forUser($locked->user)->credit(
                $locked->amount,
                'شارژ کیف‌پول از درگاه زرین‌پال — پیگیری '.$result['ref_id'],
            );

            $locked->update([
                'status'                => 'paid',
                'ref_id'                => $result['ref_id'],
                'card_pan'              => $result['card_pan'] ?? null,
                'wallet_transaction_id' => $tx->id,
                'paid_at'               => Carbon::now(),
            ]);
        });

        return redirect()->route('wallet')->with(
            'success',
            'کیف‌پول شما با موفقیت شارژ شد. کد پیگیری: '.$result['ref_id']
        );
    }


    /*
    |--------------------------------------------------------------------------
    | برداشت از کیف‌پول
    |--------------------------------------------------------------------------
    |
    | مبلغ همین‌جا کسر می‌شود، نه موقع تایید ادمین — وگرنه کاربر می‌توانست
    | همان موجودی را همزمان جای دیگری هم خرج کند و کیف‌پول منفی شود.
    | رد کردن درخواست توسط ادمین مبلغ را برمی‌گرداند.
    |
    */

    public function withdraw(Request $request)
    {
        $user = Auth::user();

        $min = (int) config('services.wallet.min_withdrawal', 100000);

        $data = $request->validate([
            'amount'         => "required|integer|min:{$min}",
            'iban'           => 'required|string|regex:/^IR[0-9]{24}$/',
            'account_holder' => 'required|string|max:120',
        ], [
            'iban.regex' => 'شماره شبا باید با IR شروع شود و ۲۴ رقم داشته باشد.',
        ], [
            'amount'         => 'مبلغ',
            'iban'           => 'شماره شبا',
            'account_holder' => 'نام صاحب حساب',
        ]);

        $wallet = Wallet::forUser($user);

        try {

            DB::transaction(function () use ($wallet, $user, $data) {

                $wallet->debit(
                    (int) $data['amount'],
                    'درخواست برداشت به شبا ' . $data['iban'],
                );

                WalletWithdrawal::create([
                    'user_id'        => $user->id,
                    'amount'         => (int) $data['amount'],
                    'iban'           => $data['iban'],
                    'account_holder' => $data['account_holder'],
                ]);

            });

        } catch (\App\Exceptions\InsufficientWalletBalanceException $e) {
            return back()->with('error', 'موجودی کیف‌پول برای این برداشت کافی نیست.');
        }

        return back()->with('success', 'درخواست برداشت ثبت شد و پس از بررسی واریز می‌شود.');
    }

}
