<?php

namespace App\Filament\Moderator\Resources\Auctions\Pages;

use App\Filament\Moderator\Resources\Auctions\AuctionResource;
use Filament\Resources\Pages\EditRecord;

class EditAuction extends EditRecord
{
    protected static string $resource = AuctionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
