<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NavasanService
{
    public function getUsdPrice(): ?array
    {
        $apiKey = config('services.navasan.key');

        $response = Http::timeout(10)->get("https://api.navasan.tech/latest/", [
            'api_key' => $apiKey,
        ]);

        if (! $response->successful()) {
            return null;
        }

        $data = $response->json();

        if (! isset($data['usd_sell'])) {
            return null;
        }

        return [
            'price' => $data['usd_sell']['value'] ?? null,
            'change' => $data['usd_sell']['change'] ?? null,
            'date' => $data['usd_sell']['date'] ?? null,
        ];
    }
}