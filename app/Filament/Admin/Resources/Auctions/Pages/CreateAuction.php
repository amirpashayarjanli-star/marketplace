<?php

namespace App\Filament\Admin\Resources\Auctions\Pages;

use App\Filament\Admin\Resources\Auctions\AuctionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreateAuction extends CreateRecord
{
    protected static string $resource = AuctionResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // برای مناقصه‌ای که ادمین همین‌جا فعال می‌سازد، زمان‌ها را کامل کن.
        if (($data['status'] ?? null) === 'active') {
            $data['starts_at'] ??= Carbon::now();
            $data['ends_at']   ??= Carbon::now()->addDays(7);
        }

        // مناقصه‌ی ستاد کارفرمای داخلی ندارد.
        if (($data['source'] ?? null) === 'external') {
            $data['employer_id'] = null;
        }

        return $data;
    }
}
