<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/*
| توابع کمکی (jdate و ...) را بارگذاری می‌کند.
|
| عمداً از autoload.files کامپوزر استفاده نمی‌کنیم: نصب روی هاست اشتراکی
| با یک اسکریپت PHP انجام می‌شود و آنجا composer dump-autoload در دسترس
| نیست، پس ثبت در providers تنها راهی است که با کپی فایل کار می‌کند.
*/

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once app_path('Support/helpers.php');
    }
}
