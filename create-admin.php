<?php
/**
 * سازنده‌ی اکانت ادمین — عمومی
 *
 * این فایل رو توی public_html آپلود کن و آدرسش رو باز کن.
 * خودش لاراول رو بوت می‌کنه، اکانت ادمین رو با شماره و رمزی که پایین
 * تعریف شده می‌سازه (یا اگه از قبل بود، رمزش رو آپدیت می‌کنه)، کش‌ها
 * رو پاک می‌کنه، و در آخر خودش رو حذف می‌کنه.
 */
set_time_limit(60);
header('Content-Type: text/plain; charset=utf-8');
while (ob_get_level() > 0) { ob_end_flush(); }

function say($m = '') { echo $m . "\n"; if (ob_get_level() > 0) { ob_flush(); } flush(); }

// ── اطلاعات اکانت ادمین ─────────────────────────────────────────────
$ADMIN_NAME     = 'مدیر سیستم';
$ADMIN_MOBILE   = '09044815092';
$ADMIN_PASSWORD = 'amirjon.2020';

$publicHtml = __DIR__;
$appRoot    = realpath(__DIR__ . '/../asansorpro_app');

say('ساخت اکانت ادمین — ' . date('Y-m-d H:i:s'));
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
        $user->update([
            'name'     => $ADMIN_NAME,
            'password' => \Illuminate\Support\Facades\Hash::make($ADMIN_PASSWORD),
            'role'     => 'admin',
            'status'   => 'approved',
        ]);
        say('✅ اکانت ادمین از قبل وجود داشت — اطلاعاتش به‌روزرسانی شد.');
    } else {
        \App\Models\User::create([
            'name'     => $ADMIN_NAME,
            'mobile'   => $ADMIN_MOBILE,
            'password' => \Illuminate\Support\Facades\Hash::make($ADMIN_PASSWORD),
            'role'     => 'admin',
            'status'   => 'approved',
        ]);
        say('✅ اکانت ادمین ساخته شد.');
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
say('🔐 اطلاعات ورود:');
say('   موبایل: ' . $ADMIN_MOBILE);
say('   رمز:    ' . $ADMIN_PASSWORD);
say('   لینک:   https://asansorpro.com/login');
say('');
say('این اسکریپت خودش الان حذف میشه.');

@unlink(__FILE__);
