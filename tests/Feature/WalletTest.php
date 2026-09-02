<?php

use App\Exceptions\InsufficientWalletBalanceException;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;

/*
| کیف‌پول تنها جایی است که پول کاربر جابه‌جا می‌شود. قاعده‌ی کلاس این
| است که موجودی فقط از راه credit/debit عوض شود تا هر تغییر تراکنش
| خودش را داشته باشد؛ این تست‌ها همان قاعده را می‌بندند.
*/

function walletUser(): User
{
    return User::create([
        'name'     => 'کاربر تست',
        'mobile'   => '0912' . fake()->unique()->numerify('#######'),
        'password' => 'x',
        'status'   => 'approved',
    ]);
}

it('واریز، موجودی را بالا می‌برد و تراکنشش را ثبت می‌کند', function () {

    $wallet = Wallet::forUser(walletUser());

    $tx = $wallet->credit(50_000, 'شارژ آزمایشی');

    expect($wallet->fresh()->balance)->toBe(50_000)
        ->and($tx->type)->toBe('credit')
        ->and($tx->amount)->toBe(50_000)
        ->and($wallet->transactions()->count())->toBe(1);
});


it('برداشت، موجودی را پایین می‌آورد و تراکنشش را ثبت می‌کند', function () {

    $wallet = Wallet::forUser(walletUser());
    $wallet->credit(50_000, 'شارژ');

    $tx = $wallet->debit(20_000, 'کارمزد');

    expect($wallet->fresh()->balance)->toBe(30_000)
        ->and($tx->type)->toBe('debit')
        ->and($tx->amount)->toBe(20_000);
});


/*
| مهم‌ترین تست این فایل: برداشتِ بیش از موجودی نباید نه پول کم کند نه
| تراکنش بسازد. اگر روزی این بشکند، کاربر بدهکار می‌شود بی‌آنکه جایی
| ثبت شده باشد.
*/
it('برداشت بیش از موجودی را رد می‌کند و هیچ چیز را تغییر نمی‌دهد', function () {

    $wallet = Wallet::forUser(walletUser());
    $wallet->credit(10_000, 'شارژ');

    expect(fn () => $wallet->debit(10_001, 'برداشت زیادی'))
        ->toThrow(InsufficientWalletBalanceException::class);

    expect($wallet->fresh()->balance)->toBe(10_000)
        ->and(WalletTransaction::where('type', 'debit')->count())->toBe(0);
});


it('برداشتِ دقیقاً برابر موجودی مجاز است و صفرش می‌کند', function () {

    $wallet = Wallet::forUser(walletUser());
    $wallet->credit(10_000, 'شارژ');

    $wallet->debit(10_000, 'برداشت کامل');

    expect($wallet->fresh()->balance)->toBe(0);
});


it('برای هر کاربر فقط یک کیف‌پول می‌سازد', function () {

    $user = walletUser();

    $first  = Wallet::forUser($user);
    $second = Wallet::forUser($user);

    expect($second->id)->toBe($first->id)
        ->and(Wallet::where('user_id', $user->id)->count())->toBe(1);
});


it('موجودی کیف‌پول تازه صفر است', function () {

    expect(Wallet::forUser(walletUser())->balance)->toBe(0);
});
