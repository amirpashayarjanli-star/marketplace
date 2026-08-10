<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SmsService
{

    public function sendOtp(string $mobile, string $code): bool
    {

        try {


            $response = Http::asForm()
                ->post(
                    'https://rest.payamak-panel.com/api/SendSMS/SendSMS',
                    [

                        'username' => env('MELIPAYAMAK_USERNAME'),

                        'password' => env('MELIPAYAMAK_PASSWORD'),

                        'from' => env('MELIPAYAMAK_NUMBER'),

                        'to' => $mobile,

                        'text' => "کد تایید آسانسور پرو: ".$code,

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
