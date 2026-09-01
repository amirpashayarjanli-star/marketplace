<?php

namespace App\Console\Commands;

use App\Services\AuctionService;
use Illuminate\Console\Command;


class CloseEndedAuctions extends Command
{

    protected $signature = 'auctions:close';

    protected $description = 'بستن مزایده‌هایی که مهلتشان تمام شده و اطلاع به کارفرما';


    public function handle(AuctionService $auctions): int
    {

        $count = $auctions->closeEnded();

        $this->info("{$count} مزایده بسته شد.");

        return self::SUCCESS;
    }
}
