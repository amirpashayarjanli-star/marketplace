<?php

use App\Exceptions\InsufficientWalletBalanceException;
use App\Models\Building;
use App\Models\Customer;
use App\Models\MaintenanceVisit;
use App\Models\ServiceContract;
use App\Models\User;
use App\Models\Wallet;
use App\Services\ServiceContractService;

/*
| فعال‌سازی قرارداد، پول را از کیف‌پول مشتری برمی‌دارد و در همان
| تراکنش وضعیت و تاریخ‌ها را می‌نویسد و برنامه‌ی بازدیدها را می‌سازد.
| «همه یا هیچ» بودنش همان چیزی است که این تست‌ها می‌بندند.
*/

function contractFor(string $plan = 'periodic', string $term = 'yearly'): ServiceContract
{
    $user = User::create([
        'name'     => 'مشتری تست',
        'mobile'   => '0914' . fake()->unique()->numerify('#######'),
        'password' => 'x',
        'type'     => 'customer',
        'status'   => 'approved',
    ]);

    $customer = Customer::create([
        'user_id' => $user->id,
        'name'    => 'مشتری تست',
        'mobile'  => $user->mobile,
    ]);

    $building = Building::create([
        'customer_id' => $customer->id,
        'title'       => 'ساختمان تست',
        'address'     => 'نشانی تست',
    ]);

    $building->elevators()->create(['label' => 'آسانسور ۱']);

    return app(ServiceContractService::class)
        ->request($building, $plan, $term, 'assigned', null);
}


it('قرارداد در وضعیت در انتظار بررسی ساخته می‌شود و قیمت می‌گیرد', function () {

    $contract = contractFor();

    expect($contract->status)->toBe('pending_review')
        ->and($contract->total_amount)->toBeGreaterThan(0)
        ->and($contract->months)->toBe(12)
        ->and($contract->code)->not->toBeEmpty();
});


it('فعال‌سازی، پول را برمی‌دارد و قرارداد را فعال و تاریخ‌دار می‌کند', function () {

    $contract = contractFor();
    $user     = $contract->building->customer->user;

    Wallet::forUser($user)->credit($contract->total_amount, 'شارژ');

    app(ServiceContractService::class)->activateFromWallet($contract);

    $contract->refresh();

    expect(Wallet::forUser($user)->fresh()->balance)->toBe(0)
        ->and($contract->status)->toBe('active')
        ->and($contract->paid_at)->not->toBeNull()
        ->and($contract->starts_at)->not->toBeNull()
        ->and($contract->ends_at)->not->toBeNull();
});


/*
| مهم‌ترین تست: اگر موجودی نرسد، نه پولی کم شود نه قرارداد فعال شود.
| بدون رول‌بک، مشتری قرارداد فعال داشت بی‌آنکه پولی داده باشد.
*/
it('اگر موجودی نرسد، قرارداد فعال نمی‌شود و پولی هم کم نمی‌شود', function () {

    $contract = contractFor();
    $user     = $contract->building->customer->user;

    Wallet::forUser($user)->credit($contract->total_amount - 1, 'یک تومان کمتر');

    expect(fn () => app(ServiceContractService::class)->activateFromWallet($contract))
        ->toThrow(InsufficientWalletBalanceException::class);

    $contract->refresh();

    expect($contract->status)->toBe('pending_review')
        ->and($contract->paid_at)->toBeNull()
        ->and(Wallet::forUser($user)->fresh()->balance)->toBe($contract->total_amount - 1)
        ->and(MaintenanceVisit::count())->toBe(0);
});


it('برای طرح دوره‌ای، برنامه‌ی بازدیدها ساخته می‌شود', function () {

    $contract = contractFor('periodic', 'yearly');
    $user     = $contract->building->customer->user;

    Wallet::forUser($user)->credit($contract->total_amount, 'شارژ');

    app(ServiceContractService::class)->activateFromWallet($contract);

    expect(MaintenanceVisit::where('service_contract_id', $contract->id)->count())
        ->toBeGreaterThan(0);
});


it('برای طرح موردی، بازدید دوره‌ای ساخته نمی‌شود', function () {

    $contract = contractFor('on_demand', 'yearly');
    $user     = $contract->building->customer->user;

    // طرح موردی اجاره‌ی ماهانه ندارد، پس مبلغش صفر است
    Wallet::forUser($user)->credit(max(1, $contract->total_amount), 'شارژ');

    app(ServiceContractService::class)->activateFromWallet($contract);

    expect($contract->refresh()->status)->toBe('active')
        ->and(MaintenanceVisit::where('service_contract_id', $contract->id)->count())->toBe(0);
});


it('لغو قرارداد، بازدیدهای انجام‌نشده را هم بی‌اثر می‌کند', function () {

    $contract = contractFor();
    $user     = $contract->building->customer->user;

    Wallet::forUser($user)->credit($contract->total_amount, 'شارژ');

    $service = app(ServiceContractService::class);
    $service->activateFromWallet($contract);
    $service->cancel($contract, 'تست');

    expect($contract->refresh()->status)->toBe('cancelled')
        ->and(MaintenanceVisit::where('service_contract_id', $contract->id)->where('status', 'due')->count())->toBe(0);
});
