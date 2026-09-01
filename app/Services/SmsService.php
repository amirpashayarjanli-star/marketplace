<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SmsService
{

    public function sendOtp(string $mobile, string $code): bool
    {

        return $this->send($mobile, "کد تایید آسانسور پرو: ".$code);

    }




    /**
     * ارسال یک پیامک متنی دلخواه. اگر تنظیمات پیامک ناقص باشد یا خطایی
     * رخ دهد، false برمی‌گرداند و جریان کار را متوقف نمی‌کند.
     */
    public function send(string $mobile, string $text): bool
    {

        try {


            $response = Http::asForm()
                ->post(
                    'https://rest.payamak-panel.com/api/SendSMS/SendSMS',
                    [

                        // با config می‌خوانیم نه env — بعد از php artisan
                        // config:cache تابع env() همیشه null برمی‌گرداند و
                        // پیامک بی‌سروصدا ارسال نمی‌شد.
                        'username' => config('services.melipayamak.username'),

                        'password' => config('services.melipayamak.password'),

                        'from' => config('services.melipayamak.from'),

                        'to' => $mobile,

                        'text' => $text,

                    ]
                );



            if ($response->successful()) {

                return true;

            }



            Log::error(
                'Melipayamak SMS Error',
                [
                    'response' => $response->body()
                ]
            );


            return false;



        } catch (\Exception $e) {


            Log::error(
                'Melipayamak Exception',
                [
                    'message' => $e->getMessage()
                ]
            );


            return false;

        }

    }

}
