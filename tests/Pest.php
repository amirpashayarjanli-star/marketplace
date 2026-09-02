<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
| هر تست روی یک دیتابیس sqlite در حافظه اجرا می‌شود (phpunit.xml) و
| RefreshDatabase قبل از هر تست میگریشن‌ها را از نو می‌سازد، پس
| تست‌ها به داده‌ی لوکال دست نمی‌زنند.
*/
pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature', 'Unit');
