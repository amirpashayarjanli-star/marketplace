<?php
/**
 * اسکریپت رفع مشکلات آسانسور پرو — یک‌بار مصرف
 * -----------------------------------------------------------------
 * نحوه استفاده:
 *   ۱. این فایل را داخل پوشه‌ی public_html (کنار index.php سایت) آپلود کن.
 *   ۲. آدرس زیر را در مرورگر باز کن (کلید امنیتی را خودت عوض کن، پایین توضیح داده شده):
 *      https://یامنی-شما/fix-site.php?key=CHANGE_ME_TO_A_LONG_RANDOM_STRING
 *   ۳. بعد از دیدن پیام "همه چیز تمام شد"، این فایل را از روی هاست حذف کن.
 *
 * این اسکریپت فقط کارهای سمت سرور را انجام می‌دهد (migrate، پاک کردن
 * کش‌های کانفیگ/روت/ویو، ساخت symlink استوریج). خودِ باگ‌های کد
 * (کرش پروفایل تکنسین، قفل شدن پنل ادمین، مسیر تداخلی نظرات، ارسال
 * پیامک OTP، و غیره) در فایل‌های PHP/Blade پروژه اصلاح شده‌اند — پس
 * برای رفع کامل باید نسخه‌ی جدید فایل‌های زیر را هم روی هاست جایگزین کنی
 * (از طریق git pull یا آپلود مستقیم همان فایل‌ها):
 *
 *   app/Models/User.php
 *   app/Http/Controllers/OtpController.php
 *   app/Http/Controllers/AuthController.php
 *   app/Http/Controllers/DashboardController.php
 *   app/Services/SmsService.php
 *   config/services.php
 *   routes/web.php
 *   resources/views/auth/login-otp.blade.php
 *   resources/views/pages/profile/technician/sections/hero.blade.php
 *   resources/views/pages/profile/technician/sections/skills.blade.php
 *   resources/views/sections/latest-inquiries.blade.php
 *   resources/views/sections/latest-projects.blade.php
 *
 * فقط بعد از آپلود این فایل‌ها این اسکریپت را اجرا کن تا کش‌های سرور هم
 * با کد جدید هماهنگ شوند — وگرنه لاراول همچنان نسخه‌ی کش‌شده‌ی قدیمی
 * (config:cache / route:cache / view:cache) را سرو می‌کند.
 */

// -----------------------------------------------------------------------
// ۱) کلید امنیتی — قبل از آپلود این مقدار را به یک رشته‌ی تصادفی طولانی
//    تغییر بده تا کس دیگری نتواند این اسکریپت را روی سایتت اجرا کند.
// -----------------------------------------------------------------------
const SECRET_KEY = 'CHANGE_ME_TO_A_LONG_RANDOM_STRING';

header('Content-Type: text/html; charset=utf-8');

function out(string $msg, string $type = 'info'): void
{
    $color = ['ok' => '#16a34a', 'error' => '#dc2626', 'info' => '#334155'][$type] ?? '#334155';
    $icon  = ['ok' => '✔', 'error' => '✘', 'info' => '•'][$type] ?? '•';
    echo "<div style=\"color:$color;font-family:monospace;padding:2px 0\">$icon " . htmlspecialchars($msg) . "</div>";
    @ob_flush();
    @flush();
}

echo "<!doctype html><html lang='fa' dir='rtl'><head><meta charset='utf-8'>
<title>رفع مشکلات آسانسور پرو</title>
<style>body{background:#0f172a;color:#e2e8f0;font-family:sans-serif;padding:30px;max-width:800px;margin:auto}
h1{font-size:20px}pre{white-space:pre-wrap;background:#1e293b;padding:12px;border-radius:8px}</style>
</head><body>";
echo "<h1>🔧 رفع مشکلات آسانسور پرو</h1>";

if (SECRET_KEY === 'CHANGE_ME_TO_A_LONG_RANDOM_STRING') {
    out('کلید امنیتی هنوز پیش‌فرض است. اول بالای همین فایل SECRET_KEY را عوض کن، دوباره آپلودش کن، بعد دوباره باز کن.', 'error');
    echo "</body></html>";
    exit;
}

if (! isset($_GET['key']) || ! hash_equals(SECRET_KEY, (string) $_GET['key'])) {
    http_response_code(403);
    out('دسترسی غیرمجاز. آدرس را با ?key=... درست وارد کن.', 'error');
    echo "</body></html>";
    exit;
}

// -----------------------------------------------------------------------
// ۲) پیدا کردن ریشه‌ی پروژه‌ی لاراول
//    اگر این فایل داخل public_html و لاراول یک پوشه بالاتر است (طبق
//    راهنمای DEPLOYMENT_CPANEL.md) مسیر را اصلاح کن.
// -----------------------------------------------------------------------
$candidates = [
    __DIR__,                    // لاراول و public_html یکی هستند
    dirname(__DIR__),           // public_html زیرپوشه‌ی ریشه‌ی لاراول است
    __DIR__ . '/asansor-pro',   // پوشه‌ی مجزا کنار public_html
];

$basePath = null;
foreach ($candidates as $c) {
    if (is_file($c . '/artisan') && is_file($c . '/bootstrap/app.php')) {
        $basePath = rtrim($c, '/');
        break;
    }
}

if (! $basePath) {
    out('پوشه‌ی ریشه‌ی لاراول (فایل artisan) پیدا نشد. مسیر $candidates را در بالای اسکریپت با مسیر واقعی هاستت اصلاح کن.', 'error');
    echo "</body></html>";
    exit;
}

out("ریشه‌ی پروژه پیدا شد: $basePath", 'ok');

require $basePath . '/vendor/autoload.php';
$app = require_once $basePath . '/bootstrap/app.php';

/** @var \Illuminate\Foundation\Application $app */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function runArtisan($kernel, string $command, array $params = []): void
{
    $exit = $kernel->call($command, $params);
    $output = trim($kernel->output());
    out(($exit === 0 ? "$command  →  OK" : "$command  →  خطا (کد $exit)"), $exit === 0 ? 'ok' : 'error');
    if ($output !== '') {
        echo "<pre>" . htmlspecialchars($output) . "</pre>";
    }
}

echo "<h3>۱. پاک کردن کش‌های قدیمی</h3>";
runArtisan($kernel, 'optimize:clear');

echo "<h3>۲. اجرای Migration های جدید</h3>";
runArtisan($kernel, 'migrate', ['--force' => true]);

echo "<h3>۳. اتصال Storage Symlink</h3>";
if (is_link($basePath . '/public/storage') || is_dir($basePath . '/public/storage')) {
    out('public/storage از قبل وجود دارد.', 'ok');
} else {
    runArtisan($kernel, 'storage:link');
}

echo "<h3>۴. بازسازی کش‌ها برای Production</h3>";
runArtisan($kernel, 'config:cache');
runArtisan($kernel, 'route:cache');
runArtisan($kernel, 'view:cache');

echo "<h3>۵. بررسی سریع تنظیمات حیاتی</h3>";
$checks = [
    'APP_KEY تنظیم شده' => filled(config('app.key')),
    'APP_ENV = production' => config('app.env') === 'production',
    'APP_DEBUG خاموش است' => config('app.debug') === false,
    'اتصال دیتابیس برقرار است' => (function () {
        try { \Illuminate\Support\Facades\DB::connection()->getPdo(); return true; }
        catch (\Throwable $e) { return false; }
    })(),
    'اطلاعات ملی‌پیامک تنظیم شده' => filled(config('services.melipayamak.username'))
        && filled(config('services.melipayamak.password'))
        && filled(config('services.melipayamak.from')),
];
foreach ($checks as $label => $ok) {
    out($label, $ok ? 'ok' : 'error');
}

echo "<h2 style='color:#16a34a'>✅ همه چیز تمام شد</h2>";
echo "<p>حالا حتماً همین فایل (fix-site.php) را از روی هاست حذف کن تا کسی دیگر نتواند دوباره اجرایش کند.</p>";
echo "</body></html>";
