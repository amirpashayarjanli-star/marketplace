<?php
/**
 * اصلاح اکانت ادمین — عمومی
 *
 * این فایل رو توی public_html آپلود کن و آدرسش رو باز کن.
 * اکانت با شماره‌ی زیر رو واقعاً ادمین می‌کنه: هم role رو admin می‌ذاره
 * هم type رو خالی می‌کنه (اگه type چیزی مثل company/employer باشه،
 * داشبورد به‌جای پنل ادمین، داشبورد همون کسب‌وکار رو نشون می‌ده).
 *
 * در آخر خودش رو حذف می‌کنه.
 */
set_time_limit(60);
header('Content-Type: text/plain; charset=utf-8');
while (ob_get_level() > 0) { ob_end_flush(); }

function say($m = '') { echo $m . "\n"; if (ob_get_level() > 0) { ob_flush(); } flush(); }

// ── اکانتی که باید ادمین بشه ─────────────────────────────────────────
$ADMIN_MOBILE   = '09044815092';
$ADMIN_NAME     = 'مدیر سیستم';
$ADMIN_PASSWORD = 'amirjon.2020'; // فقط اگه از قبل وجود نداشت، ساخته میشه

$appRoot = realpath(__DIR__ . '/../asansorpro_app');

say('اصلاح اکانت ادمین — ' . date('Y-m-d H:i:s'));
say('');

if (!$appRoot) {
    say('❌ پوشه‌ی asansorpro_app پیدا نشد (باید کنار public_html باشه).');
    exit;
}

try {
    require_once $appRoot . '/vendor/autoload.php';
    $app = require_once $appRoot . '/bootstrap/app.php';
    $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
    $kernel->bootstrap();

    $user = \App\Models\User::where('mobile', $ADMIN_MOBILE)->first();

    if ($user) {
        $before = $user->only(['mobile', 'name', 'type', 'role', 'status']);

        $user->update([
            'type'   => null,   // مهم‌ترین اصلاح — وگرنه داشبورد بر اساس type قدیمی نشون داده میشه
            'role'   => 'admin',
            'status' => 'approved',
        ]);

        say('✅ اکانت پیدا شد و اصلاح شد.');
        say('   قبل: ' . json_encode($before, JSON_UNESCAPED_UNICODE));
        say('   بعد: ' . json_encode($user->fresh()->only(['mobile', 'name', 'type', 'role', 'status']), JSON_UNESCAPED_UNICODE));
    } else {
        \App\Models\User::create([
            'name'     => $ADMIN_NAME,
            'mobile'   => $ADMIN_MOBILE,
            'password' => \Illuminate\Support\Facades\Hash::make($ADMIN_PASSWORD),
            'role'     => 'admin',
            'status'   => 'approved',
        ]);
        say('✅ اکانت وجود نداشت — از صفر ساخته شد.');
    }

    foreach (['config:clear', 'cache:clear'] as $cmd) {
        \Illuminate\Support\Facades\Artisan::call($cmd);
    }
    say('✅ کش‌ها پاک شد.');

} catch (\Throwable $e) {
    say('❌ خطا: ' . $e->getMessage());
    say('   فایل: ' . $e->getFile() . ' (خط ' . $e->getLine() . ')');
    exit;
}

say('');
say('🔐 حالا با این اطلاعات وارد شو و باید مستقیم به پنل تایید کاربران بری:');
say('   موبایل: ' . $ADMIN_MOBILE);
say('   لینک:   https://asansorpro.com/login');
say('');
say('این اسکریپت خودش الان حذف میشه.');

@unlink(__FILE__);
