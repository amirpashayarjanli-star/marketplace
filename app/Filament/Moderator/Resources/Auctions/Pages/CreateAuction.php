<?php

namespace App\Filament\Moderator\Resources\Auctions\Pages;

use App\Filament\Moderator\Resources\Auctions\AuctionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreateAuction extends CreateRecord
{
    protected static string $resource = AuctionResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['status'] ?? null) === 'active') {
            $data['starts_at'] ??= Carbon::now();
            $data['ends_at']   ??= Carbon::now()->addDays(7);
        }

        if (($data['source'] ?? null) === 'external') {
            $data['employer_id'] = null;
        }

        return $data;
    }
}
