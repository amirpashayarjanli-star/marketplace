<?php

use App\Exceptions\InsufficientWalletBalanceException;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Models\Wallet;
use App\Services\AuctionService;
use Illuminate\Validation\ValidationException;

/*
| ثبت پیشنهاد، کارمزد را از کیف‌پول کم می‌کند. پیشنهاد و برداشت داخل یک
| DB::transaction هستند، پس یا هر دو باید بیفتند یا هیچ‌کدام — این تست‌ها
| همان تضمین را می‌بندند.
*/

function bidder(string $type = 'company'): User
{
    return User::create([
        'name'     => 'پیشنهاددهنده',
        'mobile'   => '0913' . fake()->unique()->numerify('#######'),
        'password' => 'x',
        'type'     => $type,
        'status'   => 'approved',
    ]);
}

function openAuction(array $overrides = []): Auction
{
    return Auction::create(array_merge([
        'title'        => 'نصب آسانسور برج آزمایشی',
        'scope'        => 'install',
        'status'       => 'active',
        'bids_enabled' => true,
        'fee_percent'  => 5,
        'ends_at'      => now()->addDays(3),
    ], $overrides));
}


it('کارمزد را از کیف‌پول کم می‌کند و تراکنش را به پیشنهاد وصل می‌کند', function () {

    $user = bidder();
    Wallet::forUser($user)->credit(1_000_000, 'شارژ');

    $auction = openAuction();

    $bid = app(AuctionService::class)->placeBid($auction, $user, ['amount' => 2_000_000]);

    // ۵٪ از ۲٬۰۰۰٬۰۰۰ = ۱۰۰٬۰۰۰
    expect(Wallet::forUser($user)->fresh()->balance)->toBe(900_000)
        ->and($bid->amount)->toBe(2_000_000)
        ->and($bid->fee_transaction_id)->not->toBeNull();
});


/*
| مهم‌ترین تست: اگر موجودی برای کارمزد کم باشد، نباید پیشنهادی در
| دیتابیس بماند. بدون رول‌بک، کاربر پیشنهاد ثبت‌شده داشت بی‌آنکه
| کارمزدی پرداخت کرده باشد.
*/
it('اگر موجودی کارمزد نرسد، نه پیشنهادی می‌ماند نه پولی کم می‌شود', function () {

    $user = bidder();
    Wallet::forUser($user)->credit(10_000, 'شارژ کم');

    $auction = openAuction();

    expect(fn () => app(AuctionService::class)->placeBid($auction, $user, ['amount' => 2_000_000]))
        ->toThrow(InsufficientWalletBalanceException::class);

    expect(Bid::count())->toBe(0)
        ->and(Wallet::forUser($user)->fresh()->balance)->toBe(10_000);
});


it('دو بار پیشنهاد دادن در یک مزایده را رد می‌کند', function () {

    $user = bidder();
    Wallet::forUser($user)->credit(1_000_000, 'شارژ');

    $auction = openAuction();
    $service = app(AuctionService::class);

    $service->placeBid($auction, $user, ['amount' => 2_000_000]);

    expect(fn () => $service->placeBid($auction, $user, ['amount' => 1_900_000]))
        ->toThrow(ValidationException::class);

    expect(Bid::count())->toBe(1);
});


it('روی مزایده‌ی بسته پیشنهاد نمی‌پذیرد', function () {

    $user = bidder();
    Wallet::forUser($user)->credit(1_000_000, 'شارژ');

    $auction = openAuction(['status' => 'closed']);

    expect(fn () => app(AuctionService::class)->placeBid($auction, $user, ['amount' => 2_000_000]))
        ->toThrow(ValidationException::class);

    expect(Bid::count())->toBe(0);
});


it('از کاربر تاییدنشده پیشنهاد نمی‌پذیرد', function () {

    $user = bidder();
    $user->update(['status' => 'pending']);
    Wallet::forUser($user)->credit(1_000_000, 'شارژ');

    expect(fn () => app(AuctionService::class)->placeBid(openAuction(), $user, ['amount' => 2_000_000]))
        ->toThrow(ValidationException::class);

    expect(Bid::count())->toBe(0);
});


it('نوع حسابی که مجاز نیست را رد می‌کند', function () {

    // کار «نصب» فقط برای شرکت‌هاست، نه فروشگاه
    $store = bidder('store');
    Wallet::forUser($store)->credit(1_000_000, 'شارژ');

    expect(fn () => app(AuctionService::class)->placeBid(openAuction(['scope' => 'install']), $store, ['amount' => 2_000_000]))
        ->toThrow(ValidationException::class);

    expect(Bid::count())->toBe(0);
});


it('کارمزد را از درصد خود مزایده حساب می‌کند نه پیش‌فرض', function () {

    $user = bidder();
    Wallet::forUser($user)->credit(1_000_000, 'شارژ');

    // ۱۰٪ روی خود مزایده، نه ۵٪ پیش‌فرض
    $auction = openAuction(['fee_percent' => 10]);

    app(AuctionService::class)->placeBid($auction, $user, ['amount' => 1_000_000]);

    expect(Wallet::forUser($user)->fresh()->balance)->toBe(900_000);
});
