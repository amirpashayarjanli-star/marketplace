<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


/*
|--------------------------------------------------------------------------
| زرین‌پال — درگاه پرداخت (API نسخه ۴)
|--------------------------------------------------------------------------
|
| مبلغ‌ها همه‌جای سایت «تومان» است، پس currency را IRT می‌فرستیم و هیچ
| تبدیلی به ریال انجام نمی‌دهیم. اگر روزی خواستی ریال بفرستی، هم اینجا
| هم verify() باید با هم عوض شوند وگرنه زرین‌پال مبلغ را نامطابق می‌داند.
|
*/

class ZarinpalService
{

    public function isEnabled(): bool
    {
        return ! empty(config('services.zarinpal.merchant_id'));
    }




    private function baseUrl(): string
    {
        return config('services.zarinpal.sandbox')
            ? 'https://sandbox.zarinpal.com/pg'
            : 'https://payment.zarinpal.com/pg';
    }




    public function startUrl(string $authority): string
    {
        return $this->baseUrl().'/StartPay/'.$authority;
    }




    /*
    |--------------------------------------------------------------------------
    | درخواست پرداخت
    |--------------------------------------------------------------------------
    |
    | خروجی: ['ok' => bool, 'authority' => ?string, 'message' => ?string]
    |
    */

    public function request(int $amount, string $callbackUrl, string $description, ?string $mobile = null): array
    {

        if (! $this->isEnabled()) {
            return ['ok' => false, 'message' => 'درگاه پرداخت پیکربندی نشده است.'];
        }

        try {

            $response = Http::timeout(20)
                ->acceptJson()
                ->post($this->baseUrl().'/v4/payment/request.json', array_filter([
                    'merchant_id'  => config('services.zarinpal.merchant_id'),
                    'amount'       => $amount,
                    'currency'     => 'IRT',
                    'callback_url' => $callbackUrl,
                    'description'  => $description,
                    'metadata'     => $mobile ? ['mobile' => $mobile] : null,
                ]));

            $body = $response->json();

            $code = data_get($body, 'data.code');

            if ($code === 100 && data_get($body, 'data.authority')) {

                return [
                    'ok'        => true,
                    'authority' => data_get($body, 'data.authority'),
                ];
            }

            Log::error('Zarinpal request failed', ['body' => $body]);

            return [
                'ok'      => false,
                'message' => $this->errorMessage($body),
            ];

        } catch (\Throwable $e) {

            Log::error('Zarinpal request exception', ['message' => $e->getMessage()]);

            return ['ok' => false, 'message' => 'ارتباط با درگاه پرداخت برقرار نشد.'];
        }
    }




    /*
    |--------------------------------------------------------------------------
    | تایید پرداخت
    |--------------------------------------------------------------------------
    |
    | کد ۱۰۰ = موفق، کد ۱۰۱ = قبلاً تایید شده (باز هم موفق است، ولی نباید
    | دوباره کیف‌پول را شارژ کرد — کنترلر با یکتا بودن authority جلویش را می‌گیرد).
    |
    */

    public function verify(int $amount, string $authority): array
    {

        if (! $this->isEnabled()) {
            return ['ok' => false, 'message' => 'درگاه پرداخت پیکربندی نشده است.'];
        }

        try {

            $response = Http::timeout(20)
                ->acceptJson()
                ->post($this->baseUrl().'/v4/payment/verify.json', [
                    'merchant_id' => config('services.zarinpal.merchant_id'),
                    'amount'      => $amount,
                    'authority'   => $authority,
                ]);

            $body = $response->json();

            $code = data_get($body, 'data.code');

            if (in_array($code, [100, 101], true)) {

                return [
                    'ok'            => true,
                    'already'       => $code === 101,
                    'ref_id'        => (string) data_get($body, 'data.ref_id'),
                    'card_pan'      => data_get($body, 'data.card_pan'),
                ];
            }

            Log::error('Zarinpal verify failed', ['body' => $body, 'authority' => $authority]);

            return [
                'ok'      => false,
                'message' => $this->errorMessage($body),
            ];

        } catch (\Throwable $e) {

            Log::error('Zarinpal verify exception', ['message' => $e->getMessage()]);

            return ['ok' => false, 'message' => 'تایید پرداخت با خطا مواجه شد.'];
        }
    }




    private function errorMessage(mixed $body): string
    {
        $message = data_get($body, 'errors.message')
            ?? data_get($body, 'data.message');

        return is_string($message) && $message !== ''
            ? $message
            : 'پرداخت انجام نشد.';
    }
}
