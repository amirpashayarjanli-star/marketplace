<?php

namespace App\Support;

use DateTimeInterface;

/*
|--------------------------------------------------------------------------
| تبدیل تاریخ میلادی به شمسی
|--------------------------------------------------------------------------
|
| عمداً بدون پکیج خارجی نوشته شده. نصب روی هاست اشتراکی از طریق اسکریپت
| PHP انجام می‌شود و آنجا composer در دسترس نیست، پس هر وابستگی جدید یعنی
| نصب دستی. الگوریتم، همان تبدیل استاندارد Pournader/Toossi است.
|
*/

class Jalali
{

    public const MONTHS = [
        1 => 'فروردین', 'اردیبهشت', 'خرداد',
        'تیر', 'مرداد', 'شهریور',
        'مهر', 'آبان', 'آذر',
        'دی', 'بهمن', 'اسفند',
    ];


    public const WEEKDAYS = [
        0 => 'یکشنبه', 'دوشنبه', 'سه‌شنبه',
        'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه',
    ];


    private int $jy;
    private int $jm;
    private int $jd;


    public function __construct(
        private DateTimeInterface $date,
    ) {
        [$this->jy, $this->jm, $this->jd] = self::toJalali(
            (int) $date->format('Y'),
            (int) $date->format('n'),
            (int) $date->format('j'),
        );
    }




    /*
    |--------------------------------------------------------------------------
    | تبدیل میلادی → شمسی
    |--------------------------------------------------------------------------
    */

    public static function toJalali(int $gy, int $gm, int $gd): array
    {
        $gDayInMonth = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;

        $days = 355666
            + (365 * $gy)
            + intdiv($gy2 + 3, 4)
            - intdiv($gy2 + 99, 100)
            + intdiv($gy2 + 399, 400)
            + $gd
            + $gDayInMonth[$gm - 1];

        $jy = -1595 + (33 * intdiv($days, 12053));
        $days %= 12053;

        $jy += 4 * intdiv($days, 1461);
        $days %= 1461;

        if ($days > 365) {
            $jy += intdiv($days - 1, 365);
            $days = ($days - 1) % 365;
        }

        if ($days < 186) {
            $jm = 1 + intdiv($days, 31);
            $jd = 1 + ($days % 31);
        } else {
            $jm = 7 + intdiv($days - 186, 30);
            $jd = 1 + (($days - 186) % 30);
        }

        return [$jy, $jm, $jd];
    }




    /*
    |--------------------------------------------------------------------------
    | قالب‌بندی
    |--------------------------------------------------------------------------
    |
    | نویسه‌های پشتیبانی‌شده مثل date() هستند: Y y n m j d H G i s F M l.
    | هر نویسه‌ی دیگر عیناً چاپ می‌شود؛ با \ می‌توان از تفسیر جلوگیری کرد.
    |
    */

    public function format(string $format = 'Y/m/d'): string
    {
        $out = '';
        $len = mb_strlen($format);

        for ($i = 0; $i < $len; $i++) {

            $char = mb_substr($format, $i, 1);

            if ($char === '\\') {
                $i++;
                $out .= mb_substr($format, $i, 1);
                continue;
            }

            $out .= match ($char) {
                'Y' => (string) $this->jy,
                'y' => substr((string) $this->jy, -2),
                'n' => (string) $this->jm,
                'm' => str_pad((string) $this->jm, 2, '0', STR_PAD_LEFT),
                'j' => (string) $this->jd,
                'd' => str_pad((string) $this->jd, 2, '0', STR_PAD_LEFT),
                'F', 'M' => self::MONTHS[$this->jm] ?? '',
                'l' => self::WEEKDAYS[(int) $this->date->format('w')] ?? '',
                'H' => $this->date->format('H'),
                'G' => $this->date->format('G'),
                'i' => $this->date->format('i'),
                's' => $this->date->format('s'),
                default => $char,
            };
        }

        return $out;
    }




    public function __toString(): string
    {
        return $this->format();
    }




    /*
    |--------------------------------------------------------------------------
    | فاصله‌ی زمانی به فارسی
    |--------------------------------------------------------------------------
    */

    public function diffForHumans(?DateTimeInterface $now = null): string
    {
        $now     = $now ?? new \DateTimeImmutable();
        $seconds = $this->date->getTimestamp() - $now->getTimestamp();
        $future  = $seconds > 0;
        $seconds = abs($seconds);

        $units = [
            ['سال',  31536000],
            ['ماه',  2592000],
            ['هفته', 604800],
            ['روز',  86400],
            ['ساعت', 3600],
            ['دقیقه', 60],
        ];

        foreach ($units as [$label, $size]) {
            if ($seconds >= $size) {
                $value = intdiv($seconds, $size);

                return $future
                    ? "{$value} {$label} دیگر"
                    : "{$value} {$label} پیش";
            }
        }

        return $future ? 'لحظاتی دیگر' : 'لحظاتی پیش';
    }
}
