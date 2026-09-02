<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| نرخ‌های لحظه‌ای بازار — دلار، طلا، سکه
|--------------------------------------------------------------------------
|
| هر سه نرخ از یک درخواست به navasan خونده میشن و نتیجه کش میشه،
| چون هر بار لود صفحه‌ی اصلی نباید یک تماس شبکه بزنه.
|
| ---------------------------------------------------------------------
| واحدها — مهم‌ترین نکته‌ی این کلاس
| ---------------------------------------------------------------------
| navasan همه‌ی فیلدها رو با یک واحد نمی‌ده. سه مقیاس مختلف دارن و
| قبلاً همه‌شون ریال فرض می‌شدن و توی ویو تقسیم بر ۱۰ می‌شدن — برای
| همین دلار یک صفر کم داشت:
|
|   usd_sell  ۲۲۱٬۰۰۰      → همین الانش تومانه            (×۱)
|   18ayar    ۲۲٬۷۲۷٬۲۷۰   → ریاله، هر گرم                (÷۱۰)
|   sekkeh    ۲۲۷٬۰۰۰      → هزار ریاله                   (×۱۰۰)
|
| درستی این سه مقیاس با خود داده‌ها راستی‌آزمایی میشه:
|   طلای ۱۸ عیار ۲٬۲۷۲٬۷۲۷ ت/گرم  →  طلای ۲۴ عیار ۳٬۰۳۰٬۳۰۳ ت/گرم
|   سکه‌ی امامی ۸٫۱۳۳ گرم با عیار ۹۰۰  →  ارزش ذاتی ۲۲٬۱۸۰٬۹۰۶ ت
|   sekkeh×۱۰۰ = ۲۲٬۷۰۰٬۰۰۰ ت  →  حباب ۲٫۳٪ که عدد طبیعی بازاره.
|
| تبدیل عمداً همین‌جا انجام میشه نه توی ویو: واحدِ هر فیلد خاصیتِ
| منبعه و ویو نباید بدونه navasan چی برمی‌گردونه.
|
*/

class MarketRatesService
{
    private const CACHE_KEY = 'market_rates';
    private const CACHE_TTL = 600;   // ۱۰ دقیقه

    /**
     * فیلد هر نرخ و ضریب تبدیلش به تومان.
     *
     * @var array<string, array{label:string, field:string, mul:int, div:int}>
     */
    private const SOURCES = [
        'usd'  => ['label' => 'دلار آمریکا',  'field' => 'usd_sell', 'mul' => 1,   'div' => 1],
        'gold' => ['label' => 'طلای ۱۸ عیار', 'field' => '18ayar',   'mul' => 1,   'div' => 10],
        'coin' => ['label' => 'سکه امامی',    'field' => 'sekkeh',   'mul' => 100, 'div' => 1],
    ];


    /**
     * @return array<string, array{label:string, value:?int, change:?int, unit:string, available:bool}>
     */
    public function all(): array
    {
        $raw = $this->fetch();

        $rates = [];

        foreach (self::SOURCES as $key => $source) {
            $rates[$key] = $this->shape($source, $raw[$source['field']] ?? null);
        }

        return $rates;
    }


    /**
     * @param  array{label:string, field:string, mul:int, div:int}  $source
     */
    private function shape(array $source, ?array $node): array
    {
        $value = $this->toToman($node['value'] ?? null, $source);

        return [
            'label'     => $source['label'],
            'value'     => $value,
            'change'    => $this->toToman($node['change'] ?? null, $source),
            'unit'      => 'تومان',
            'available' => $value !== null && $value > 0,
        ];
    }


    /**
     * مقدار خام منبع رو به تومان تبدیل می‌کنه.
     *
     * @param  array{mul:int, div:int}  $source
     */
    private function toToman(int|string|null $raw, array $source): ?int
    {
        if ($raw === null || $raw === '') {
            return null;
        }

        return intdiv((int) $raw * $source['mul'], $source['div']);
    }


    private function fetch(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {

            $key = config('services.navasan.key');

            if (blank($key)) {
                return [];
            }

            try {
                $res = Http::timeout(6)
                    ->connectTimeout(3)
                    ->get('https://api.navasan.tech/latest/', ['api_key' => $key]);

                return $res->successful() ? $res->json() : [];

            } catch (\Throwable $e) {
                Log::warning('market rates unavailable: ' . $e->getMessage());
                return [];
            }
        });
    }
}
