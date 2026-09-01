<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/*
|--------------------------------------------------------------------------
| زمان‌بندی
|--------------------------------------------------------------------------
|
| روی هاست اشتراکی cPanel یک Cron Job با فاصله‌ی هر یک دقیقه لازم است:
|   php /path/to/artisan schedule:run >> /dev/null 2>&1
|
*/

Schedule::command('auctions:close')
    ->everyMinute()
    ->withoutOverlapping();

Schedule::command('auctions:notify')
    ->everyFiveMinutes()
    ->withoutOverlapping();
