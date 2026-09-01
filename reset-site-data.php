<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

/**
 * پاک‌سازی کامل داده‌های کاربران — عمومی
 *
 * این فایل رو توی public_html آپلود کن و آدرسش رو باز کن.
 * قبل از هر کاری یک پشتیبان JSON از همه‌چیز می‌گیره (توی همون پوشه،
 * حذف نمی‌شه — خودت نگهش دار یا دانلودش کن)، بعد همه‌ی کاربران،
 * پروفایل‌ها، پروژه‌ها، محصولات، نظرات، درخواست‌های سرویس، فاکتورها
 * و کیف‌پول‌ها رو پاک می‌کنه و فقط اکانت ادمین زیر رو نگه می‌داره.
 *
 * چیزهایی که پاک نمی‌شن (این‌ها «داده‌ی کاربر» نیستن، تنظیمات سایتن):
 * دسته‌بندی‌ها (Category)، برندها (Brand)، اسلایدهای صفحه اصلی (HeroSlide)،
 * لیست خدمات (Service).
 *
 * در آخر خودش رو حذف می‌کنه.
 */
set_time_limit(120);
header('Content-Type: text/plain; charset=utf-8');
while (ob_get_level() > 0) { ob_end_flush(); }

function say($m = '') { echo $m . "\n"; if (ob_get_level() > 0) { ob_flush(); } flush(); }

// ── اکانتی که باید باقی بمونه ────────────────────────────────────────
$KEEP_ADMIN_MOBILE   = '09044815092';
$KEEP_ADMIN_NAME     = 'مدیر سیستم';
$KEEP_ADMIN_PASSWORD = 'amirjon.2020'; // فقط اگه از قبل وجود نداشت، ساخته میشه

$publicHtml = __DIR__;
$appRoot    = realpath(__DIR__ . '/../asansorpro_app');

say('پاک‌سازی داده‌های کاربران — ' . date('Y-m-d H:i:s'));
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
} catch (\Throwable $e) {
    say('❌ نتونستم لاراول رو بوت کنم: ' . $e->getMessage());
    exit;
}

$tablesToBackup = [
    'users', 'companies', 'technicians', 'manufacturers', 'stores', 'employers',
    'customers', 'projects', 'products', 'reviews', 'project_inquiries', 'inquiries',
    'service_requests', 'service_invoices', 'service_invoice_items',
    'service_request_status_logs', 'wallets', 'wallet_transactions',
    'company_service', 'otp_codes',
];

// ── مرحله ۱: پشتیبان‌گیری ─────────────────────────────────────────────
say('📦 مرحله ۱: پشتیبان‌گیری از داده‌های فعلی...');

$backup = [];
foreach ($tablesToBackup as $table) {
    try {
        $backup[$table] = DB::table($table)->get()->toArray();
    } catch (\Throwable $e) {
        $backup[$table] = ['error' => $e->getMessage()];
    }
}

$backupFile = $publicHtml . '/backup-before-reset-' . date('Ymd-His') . '.json';
file_put_contents($backupFile, json_encode($backup, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

say('✅ پشتیبان ذخیره شد: ' . basename($backupFile));
say('   (این فایل حذف نمی‌شه — خودت بعداً پاکش کن یا دانلودش کن)');
say('');

// ── مرحله ۲: حذف به ترتیب وابستگی (بچه‌ها قبل از والدها) ──────────────
say('🗑️  مرحله ۲: حذف داده‌ها...');

$counts = [];

DB::transaction(function () use (&$counts, $KEEP_ADMIN_MOBILE) {

    $counts['service_request_status_logs'] = DB::table('service_request_status_logs')->count();
    DB::table('service_request_status_logs')->delete();

    $counts['service_invoice_items'] = DB::table('service_invoice_items')->count();
    DB::table('service_invoice_items')->delete();

    $counts['service_invoices'] = DB::table('service_invoices')->count();
    DB::table('service_invoices')->delete();

    $counts['wallet_transactions'] = DB::table('wallet_transactions')->count();
    DB::table('wallet_transactions')->delete();

    $counts['service_requests'] = DB::table('service_requests')->count();
    DB::table('service_requests')->delete();

    $counts['wallets'] = DB::table('wallets')->count();
    DB::table('wallets')->delete();

    $counts['reviews'] = DB::table('reviews')->count();
    DB::table('reviews')->delete();

    $counts['project_inquiries'] = DB::table('project_inquiries')->count();
    DB::table('project_inquiries')->delete();

    if (Schema::hasTable('inquiries')) {
        $counts['inquiries'] = DB::table('inquiries')->count();
        DB::table('inquiries')->delete();
    }

    $counts['company_service'] = DB::table('company_service')->count();
    DB::table('company_service')->delete();

    $counts['projects'] = DB::table('projects')->count();
    DB::table('projects')->delete();

    $counts['products'] = DB::table('products')->count();
    DB::table('products')->delete();

    $counts['customers'] = DB::table('customers')->count();
    DB::table('customers')->delete();

    $counts['employers'] = DB::table('employers')->count();
    DB::table('employers')->delete();

    $counts['stores'] = DB::table('stores')->count();
    DB::table('stores')->delete();

    $counts['manufacturers'] = DB::table('manufacturers')->count();
    DB::table('manufacturers')->delete();

    $counts['technicians'] = DB::table('technicians')->count();
    DB::table('technicians')->delete();

    $counts['companies'] = DB::table('companies')->count();
    DB::table('companies')->delete();

    $counts['otp_codes'] = DB::table('otp_codes')->count();
    DB::table('otp_codes')->delete();

    // همه‌ی کاربرها بجز اکانتی که باید بمونه
    $counts['users'] = DB::table('users')->where('mobile', '!=', $KEEP_ADMIN_MOBILE)->count();
    DB::table('users')->where('mobile', '!=', $KEEP_ADMIN_MOBILE)->delete();

});

foreach ($counts as $table => $n) {
    say("   ✓ {$table}: {$n} رکورد حذف شد");
}

say('');

// ── مرحله ۳: مطمئن شدن از وجود اکانت ادمین ────────────────────────────
say('👤 مرحله ۳: بررسی اکانت ادمین...');

$admin = \App\Models\User::where('mobile', $KEEP_ADMIN_MOBILE)->first();

if ($admin) {
    if ($admin->role !== 'admin') {
        $admin->update(['role' => 'admin', 'status' => 'approved']);
    }
    say('✅ اکانت ادمین حفظ شد (از قبل وجود داشت).');
} else {
    \App\Models\User::create([
        'name'     => $KEEP_ADMIN_NAME,
        'mobile'   => $KEEP_ADMIN_MOBILE,
        'password' => Hash::make($KEEP_ADMIN_PASSWORD),
        'role'     => 'admin',
        'status'   => 'approved',
    ]);
    say('✅ اکانت ادمین وجود نداشت — ساخته شد.');
}

say('');

// ── مرحله ۴: پاک کردن کش ──────────────────────────────────────────────
say('🧹 مرحله ۴: پاک کردن کش...');
foreach (['config:clear', 'cache:clear', 'view:clear'] as $cmd) {
    Artisan::call($cmd);
}
say('✅ کش‌ها پاک شد.');

say('');
say('🎉 تمام شد. فقط این اکانت روی سایت باقی مونده:');
say('   موبایل: ' . $KEEP_ADMIN_MOBILE);
say('   لینک ورود: https://asansorpro.com/login');
say('');
say('نکته: دسته‌بندی‌ها، برندها، اسلایدهای صفحه اصلی و لیست خدمات دست‌نخورده موندن');
say('(این‌ها تنظیمات سایت‌اند، نه داده‌ی کاربر).');
say('');
say('این اسکریپت خودش الان حذف میشه (فایل پشتیبان JSON باقی می‌مونه).');

@unlink(__FILE__);
