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
| navasan همه‌ی فیلدها رو با یک واحد نمی‌ده. قبلاً همه‌شون ریال فرض
| می‌شدن و توی ویو تقسیم بر ۱۰ می‌شدن، برای همین دلار یک صفر کم داشت.
|
|   usd_sell  ۲۲۱٬۰۰۰      → تومان            (×۱)
|   18ayar    ۲۲٬۷۵۰٬۳۶۰   → تومان، هر گرم    (×۱)
|   sekkeh    ۲۲۷٬۰۰۰      → هزار تومان       (×۱۰۰۰)
|
| این سه با هم جور در میان:
|   طلای ۱۸ عیار ۲۲٬۷۵۰٬۳۶۰ ت/گرم  →  ۲۴ عیار ۳۰٬۳۳۳٬۸۱۳ ت/گرم
|   سکه‌ی امامی ۸٫۱۳۳ گرم عیار ۹۰۰  →  ارزش ذاتی ۲۲۲٬۰۳۴٬۴۱۳ ت
|   sekkeh×۱۰۰۰ = ۲۲۷٬۰۰۰٬۰۰۰ ت   →  حباب ۲٫۲٪، عدد طبیعی بازار.
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
        'usd'  => ['label' => 'دلار آمریکا',  'field' => 'usd_sell', 'mul' => 1,    'unit' => 'تومان'],
        'gold' => ['label' => 'طلای ۱۸ عیار', 'field' => '18ayar',   'mul' => 1,    'unit' => 'تومان / گرم'],
        'coin' => ['label' => 'سکه امامی',    'field' => 'sekkeh',   'mul' => 1000, 'unit' => 'تومان'],
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
     * @param  array{label:string, field:string, mul:int, unit:string}  $source
     */
    private function shape(array $source, ?array $node): array
    {
        $value  = $this->toToman($node['value'] ?? null, $source);
        $change = $this->toToman($node['change'] ?? null, $source);

        return [
            'label'     => $source['label'],
            'value'     => $value,
            'change'    => $change,
            'percent'   => $this->percent($value, $change),
            'unit'      => $source['unit'],
            'updated'   => $this->time($node['date'] ?? null),
            'available' => $value !== null && $value > 0,
        ];
    }


    /**
     * مقدار خام منبع رو به تومان تبدیل می‌کنه.
     *
     * @param  array{mul:int}  $source
     */
    private function toToman(int|string|null $raw, array $source): ?int
    {
        if ($raw === null || $raw === '') {
            return null;
        }

        return (int) $raw * $source['mul'];
    }


    /**
     * درصد تغییر نسبت به نرخ دیروز — یعنی نسبت به «مقدار منهای تغییر»،
     * نه نسبت به خود مقدار.
     */
    private function percent(?int $value, ?int $change): ?float
    {
        if ($value === null || empty($change)) {
            return null;
        }

        $previous = $value - $change;

        if ($previous <= 0) {
            return null;
        }

        return round($change / $previous * 100, 2);
    }


    /**
     * navasan تاریخ رو همین الانش شمسی می‌ده («1405-06-11 16:23:09»)،
     * پس فقط ساعتش رو جدا می‌کنیم.
     */
    private function time(?string $date): ?string
    {
        if (blank($date) || ! str_contains($date, ' ')) {
            return null;
        }

        return substr(explode(' ', $date)[1], 0, 5);
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
