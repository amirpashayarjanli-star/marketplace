<?php

use App\Support\Jalali;

/*
|--------------------------------------------------------------------------
| تاریخ شمسی
|--------------------------------------------------------------------------
|
| در ویوها به‌جای ->format('Y/m/d') از jdate($date) استفاده کن.
| null را null برمی‌گردانند تا بتوان jdate($x) ?? '—' نوشت.
|
| این فایل توسط App\Providers\HelperServiceProvider بارگذاری می‌شود، نه
| از طریق autoload.files کامپوزر — چون نصب روی هاست بدون composer انجام
| می‌شود و آنجا امکان dump-autoload نیست.
|
*/

if (! function_exists('jdate')) {

    function jdate($date, string $format = 'Y/m/d'): ?string
    {
        if (empty($date)) {
            return null;
        }

        if (! $date instanceof DateTimeInterface) {
            $date = new DateTimeImmutable((string) $date);
        }

        return (new Jalali($date))->format($format);
    }
}


if (! function_exists('jdatetime')) {

    function jdatetime($date, string $format = 'Y/m/d H:i'): ?string
    {
        return jdate($date, $format);
    }
}


if (! function_exists('jdiff')) {

    /**
     * فاصله‌ی زمانی به فارسی — مثل «۳ روز دیگر» یا «۲ ساعت پیش».
     */
    function jdiff($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        if (! $date instanceof DateTimeInterface) {
            $date = new DateTimeImmutable((string) $date);
        }

        return (new Jalali($date))->diffForHumans();
    }
}
