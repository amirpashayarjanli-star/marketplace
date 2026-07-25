<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NavasanService
{

    public function getUsdPrice(): ?array
    {

        try {


            $apiKey = config('services.navasan.key');


            $response = Http::timeout(5)
                ->connectTimeout(3)
                ->get("https://api.navasan.tech/latest/", [

                    'api_key' => $apiKey

                ]);



            if (! $response->successful()) {

                return null;

            }



            $data = $response->json();



            if (!isset($data['usd_sell'])) {

                return null;

            }



            return [

                'price' => $data['usd_sell']['value'] ?? 0,

                'change' => $data['usd_sell']['change'] ?? 0,

                'date' => $data['usd_sell']['date'] ?? 'اکنون',

            ];



        } catch (\Exception $e) {


            return null;


        }


    }

}
