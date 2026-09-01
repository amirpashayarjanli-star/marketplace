<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| تایید برداشت‌های کیف‌پول
|--------------------------------------------------------------------------
|
| مبلغ هنگام ثبت درخواست از کیف‌پول کسر شده است. تایید فقط یعنی «واریز
| کردم»؛ رد کردن یعنی «واریز نشد» و مبلغ باید برگردد.
|
*/

class AdminWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = WalletWithdrawal::with(['user', 'processedBy'])->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        return view('admin.withdrawals.index', [
            'withdrawals'   => $query->get(),
            'statuses'      => WalletWithdrawal::STATUS_LABELS,
            'currentStatus' => $status ?? null,
        ]);
    }


    public function approve(Request $request, WalletWithdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'این درخواست قبلاً بررسی شده است.');
        }

        $validated = $request->validate([
            'reference' => 'required|string|max:100',
        ], [], ['reference' => 'شماره پیگیری واریز']);

        $withdrawal->update([
            'status'       => 'approved',
            'reference'    => $validated['reference'],
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return back()->with('success', 'برداشت تایید شد.');
    }


    public function reject(Request $request, WalletWithdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'این درخواست قبلاً بررسی شده است.');
        }

        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:300',
        ], [], ['admin_note' => 'دلیل']);

        // همه یا هیچ — نباید «رد شد» ثبت شود ولی پول برنگردد.
        DB::transaction(function () use ($withdrawal, $validated) {

            Wallet::forUser($withdrawal->user)->credit(
                $withdrawal->amount,
                'برگشت درخواست برداشت #' . $withdrawal->id,
            );

            $withdrawal->update([
                'status'       => 'rejected',
                'admin_note'   => $validated['admin_note'] ?? null,
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);

        });

        return back()->with('success', 'درخواست رد شد و مبلغ به کیف‌پول کاربر برگشت.');
    }
}
