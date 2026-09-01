<?php

namespace App\Filament\Admin\Resources\Auctions\Pages;

use App\Filament\Admin\Resources\Auctions\AuctionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuctions extends ListRecords
{
    protected static string $resource = AuctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('مناقصه‌ی جدید (از ستاد)'),
        ];
    }
}
