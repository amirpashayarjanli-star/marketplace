<?php

namespace App\Console\Commands;

use App\Services\AuctionService;
use Illuminate\Console\Command;


class NotifyNewAuctions extends Command
{

    protected $signature = 'auctions:notify';

    protected $description = 'ارسال پیامک مناقصه‌های تازه‌منتشرشده به شرکت‌های تاییدشده';


    public function handle(AuctionService $auctions): int
    {

        $count = $auctions->sendNewAuctionNotifications();

        $this->info("اطلاع‌رسانی {$count} مناقصه انجام شد.");

        return self::SUCCESS;
    }
}
