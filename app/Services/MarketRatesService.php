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
| وضعیت فعلی منابع:
|   دلار  → usd_sell   (کار می‌کند)
|   طلا   → 18ayar     (کار می‌کند)
|   سکه   → منتظر منبع معتبر است؛ مقدارهای فعلی این API با بازار
|            هم‌خوان نبودند، پس عمداً وصل نشده و کارت حالت
|            «به‌زودی» نشان می‌دهد تا عدد نادرست منتشر نشود.
|
*/

class MarketRatesService
{
    private const CACHE_KEY = 'market_rates';
    private const CACHE_TTL = 600;   // ۱۰ دقیقه

    /**
     * @return array<string, array{label:string, value:?int, change:?int, unit:string, available:bool}>
     */
    public function all(): array
    {
        $raw = $this->fetch();

        return [
            'usd'  => $this->shape('دلار آمریکا', $raw['usd_sell'] ?? null),
            'gold' => $this->shape('طلای ۱۸ عیار', $raw['18ayar'] ?? null),

            // تا وقتی منبع معتبر سکه مشخص بشه، کارت ساخته میشه ولی
            // عددی نشون نمیده — بهتر از نمایش رقم اشتباهه.
            'coin' => $this->shape('سکه امامی', null),
        ];
    }


    private function shape(string $label, ?array $node): array
    {
        $value = isset($node['value']) ? (int) $node['value'] : null;

        return [
            'label'     => $label,
            'value'     => $value,
            'change'    => isset($node['change']) ? (int) $node['change'] : null,
            'unit'      => 'تومان',
            'available' => $value !== null && $value > 0,
        ];
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


    /** نرخ‌ها به ریال میان؛ برای نمایش به تومان تبدیل میشن. */
    public static function toToman(?int $rial): ?int
    {
        return $rial === null ? null : intdiv($rial, 10);
    }
}
