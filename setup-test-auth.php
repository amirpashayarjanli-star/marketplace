<?php
/**
 * ============================================================================
 * تنظیم‌کننده‌ی کاربران تست - جریان‌های ثبتنام و ورود
 * ============================================================================
 *
 * استفاده:
 * این فایل را در ریشه‌ی پروژه (D:\AsansorPRO\marketplace) قرار دهید
 * سپس در مرورگر باز کنید:
 *   http://localhost:8000/setup-test-auth.php
 *
 * این اسکریپت:
 * 1. تمام migrations را اجرا می‌کند
 * 2. 6 کاربر تست برای تمام نقش‌ها ایجاد می‌کند
 * 3. هر کاربر با پروفایل کامل
 * 4. تمام cache ها را پاک می‌کند
 */

set_time_limit(300);
header('Content-Type: text/html; charset=utf-8');

// حذف buffering برای نمایش real-time
while (ob_get_level() > 0) {
    ob_end_flush();
}

function say($message = '', $type = 'info') {
    $colors = [
        'success' => '#27ae60',
        'error'   => '#e74c3c',
        'info'    => '#3498db',
        'warning' => '#f39c12',
    ];
    $color = $colors[$type] ?? '#333';
    echo "<div style='padding: 10px; margin: 5px 0; border-left: 4px solid $color; background: #f5f5f5;'>";
    echo "<span style='color: $color;'>" . htmlspecialchars($message) . "</span>";
    echo "</div>";
    if (ob_get_level() > 0) {
        ob_flush();
    }
    flush();
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تنظیم کاربران تست</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', 'Tahoma', 'Geneva', 'Verdana', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 15px;
            padding: 50px;
            max-width: 700px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
            font-size: 28px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #ecf0f1;
            border-radius: 3px;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            width: 0%;
            transition: width 0.3s ease;
        }
        .logs {
            max-height: 400px;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .log-item {
            padding: 8px;
            margin: 5px 0;
            border-left: 4px solid #ccc;
            border-radius: 3px;
            background: white;
            font-size: 14px;
        }
        .log-item.success {
            border-left-color: #27ae60;
            background: #ecfdf5;
            color: #27ae60;
        }
        .log-item.error {
            border-left-color: #e74c3c;
            background: #fef2f2;
            color: #e74c3c;
        }
        .log-item.info {
            border-left-color: #3498db;
            background: #eff6ff;
            color: #3498db;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: right;
            font-weight: 600;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #ecf0f1;
        }
        table tr:hover {
            background: #f8f9fa;
        }
        .links {
            margin-top: 30px;
            padding: 20px;
            background: #ecf0f1;
            border-radius: 8px;
        }
        .link-item {
            padding: 10px 0;
        }
        a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚡ تنظیم کاربران تست</h1>
        <div class="subtitle">جریان‌های ثبتنام و ورود</div>

        <div class="progress-bar">
            <div class="progress-fill" id="progress"></div>
        </div>

        <div class="logs" id="logs"></div>

        <div id="results"></div>
    </div>

    <script>
        function log(message, type = 'info') {
            const logsDiv = document.getElementById('logs');
            const item = document.createElement('div');
            item.className = 'log-item ' + type;
            item.textContent = message;
            logsDiv.appendChild(item);
            logsDiv.scrollTop = logsDiv.scrollHeight;
        }

        function updateProgress(percent) {
            document.getElementById('progress').style.width = percent + '%';
        }

        function showResults(html) {
            document.getElementById('results').innerHTML = html;
        }
    </script>
</body>
</html>

<?php

try {
    // بارگذاری Laravel
    $basePath = __DIR__;

    // پیدا کردن bootstrap/app.php
    if (!file_exists($basePath . '/bootstrap/app.php')) {
        die('<script>log("❌ نتونستم bootstrap/app.php رو پیدا کنم", "error")</script>');
    }

    require_once $basePath . '/vendor/autoload.php';
    $app = require_once $basePath . '/bootstrap/app.php';

    // بوت کردن لاراول
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

    echo '<script>log("⏳ در حال شروع...", "info")</script>';

    // Step 1: Migrations
    echo '<script>log("📋 مرحله 1: اجرای Migrations", "info"); updateProgress(20);</script>';

    ob_start();
    $kernel->call('migrate:fresh', ['--force' => true]);
    $output = ob_get_clean();

    echo '<script>log("✅ Migrations اجرا شدند", "success")</script>';

    // Step 2: ایجاد کاربران
    echo '<script>log("👥 مرحله 2: ایجاد کاربران تست", "info"); updateProgress(40);</script>';

    use App\Models\User;
    use App\Models\Company;
    use App\Models\Technician;
    use App\Models\Manufacturer;
    use App\Models\Store;
    use App\Models\Employer;
    use App\Models\Customer;
    use Illuminate\Support\Facades\Hash;

    $testData = [
        [
            'role' => 'Admin',
            'mobile' => '09044815092',
            'name' => 'مدیر سیستم',
            'type' => 'admin',
            'model' => null,
            'profile' => [],
            'isAdmin' => true,
        ],
        [
            'role' => 'Pro Service (Moderator)',
            'mobile' => '09035550001',
            'name' => 'سرویس حرفه‌ای',
            'type' => 'moderator',
            'model' => null,
            'profile' => [],
            'isModerator' => true,
        ],
        [
            'role' => 'Company',
            'mobile' => '09120000001',
            'name' => 'شرکت تست',
            'type' => 'company',
            'model' => Company::class,
            'profile' => [
                'manager_name' => 'مدیر تست',
                'phone' => '02112345678',
                'email' => 'test_company@example.com',
                'province' => 'تهران',
                'city' => 'تهران',
                'address' => 'خیابان تست، پلاک ۱۲۳',
                'description' => 'این یک پروفایل تست است با حداقل ۵۰ حرف برای پر کردن requirement.',
                'experience' => 5,
            ]
        ],
        [
            'role' => 'Technician',
            'mobile' => '09120000002',
            'name' => 'تکنسین تست',
            'type' => 'technician',
            'model' => Technician::class,
            'profile' => [
                'phone' => '02112345678',
                'experience' => 5,
                'skills' => 'تست، نگهداری، سرویس',
                'province' => 'تهران',
                'city' => 'تهران',
                'address' => 'خیابان تست، پلاک ۱۲۳',
                'description' => 'این یک پروفایل تست است با حداقل ۵۰ حرف برای پر کردن requirement.',
            ]
        ],
        [
            'role' => 'Manufacturer',
            'mobile' => '09120000003',
            'name' => 'تولیدکننده تست',
            'type' => 'manufacturer',
            'model' => Manufacturer::class,
            'profile' => [
                'manager_name' => 'مدیر تست',
                'phone' => '02112345678',
                'email' => 'test_manufacturer@example.com',
                'province' => 'تهران',
                'city' => 'تهران',
                'address' => 'خیابان تست، پلاک ۱۲۳',
                'description' => 'این یک پروفایل تست است با حداقل ۵۰ حرف برای پر کردن requirement.',
                'experience' => 5,
            ]
        ],
        [
            'role' => 'Store',
            'mobile' => '09120000004',
            'name' => 'فروشگاه تست',
            'type' => 'store',
            'model' => Store::class,
            'profile' => [
                'manager_name' => 'مدیر تست',
                'phone' => '02112345678',
                'email' => 'test_store@example.com',
                'province' => 'تهران',
                'city' => 'تهران',
                'address' => 'خیابان تست، پلاک ۱۲۳',
                'description' => 'این یک پروفایل تست است با حداقل ۵۰ حرف برای پر کردن requirement.',
                'experience' => 5,
            ]
        ],
        [
            'role' => 'Employer',
            'mobile' => '09120000005',
            'name' => 'کارفرما تست',
            'type' => 'employer',
            'model' => Employer::class,
            'profile' => [
                'phone' => '02112345678',
                'email' => 'test_employer@example.com',
                'province' => 'تهران',
                'city' => 'تهران',
                'address' => 'خیابان تست، پلاک ۱۲۳',
                'description' => 'این یک پروفایل تست است با حداقل ۵۰ حرف برای پر کردن requirement.',
            ]
        ],
        [
            'role' => 'Customer',
            'mobile' => '09120000006',
            'name' => 'مشتری تست',
            'type' => 'customer',
            'model' => Customer::class,
            'profile' => [
                'phone' => '02112345678',
                'province' => 'تهران',
                'city' => 'تهران',
                'address' => 'خیابان تست، پلاک ۱۲۳',
            ]
        ],
    ];

    $users = [];

    foreach ($testData as $data) {
        // رمز خاص برای ادمین
        $password = 'Test@1234';
        if (!empty($data['isAdmin'])) {
            $password = 'amirjon.2020';
        }

        $userArray = [
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($password),
            'type' => $data['type'],
            'status' => 'approved',
        ];

        // اگر ادمین است، role رو هم اضافه کن
        if (!empty($data['isAdmin'])) {
            $userArray['role'] = 'admin';
        }

        // اگر مودریتور است، role رو هم اضافه کن
        if (!empty($data['isModerator'])) {
            $userArray['role'] = 'moderator';
        }

        $user = User::create($userArray);

        echo '<script>log("✓ ' . $data['role'] . ': ' . $data['mobile'] . '", "success")</script>';

        if (!empty($data['isAdmin']) || !empty($data['isModerator'])) {
            // ادمین و مودریتور نیاز به پروفایل ندارن
            $data['profile'] = [];
        } elseif ($data['type'] !== 'customer' && $data['model']) {
            $profile = new $data['model']();
            $profile->user_id = $user->id;
            $profile->name = $data['name'];

            foreach ($data['profile'] as $key => $value) {
                if ($profile->isFillable($key)) {
                    $profile->$key = $value;
                }
            }

            if ($profile->isFillable('is_active')) $profile->is_active = true;
            if ($profile->isFillable('is_verified')) $profile->is_verified = true;

            $profile->save();
        } elseif ($data['type'] === 'customer') {
            Customer::create([
                'user_id' => $user->id,
                'name' => $data['name'],
            ] + $data['profile']);
        }

        $users[] = $data;
    }

    // Step 3: Cache clear
    echo '<script>log("🗑️ مرحله 3: پاک کردن Cache", "info"); updateProgress(80);</script>';

    ob_start();
    $kernel->call('cache:clear');
    $kernel->call('config:clear');
    $kernel->call('route:clear');
    $kernel->call('view:clear');
    ob_end_clean();

    echo '<script>log("✅ Cache پاک شد", "success"); updateProgress(100);</script>';

    // نمایش جدول
    $html = '<table>';
    $html .= '<thead><tr><th>نقش</th><th>شماره موبایل</th><th>رمز عبور</th></tr></thead>';
    $html .= '<tbody>';

    foreach ($users as $user) {
        $html .= '<tr>';
        $html .= '<td>' . $user['role'] . '</td>';
        $html .= '<td dir="ltr">' . $user['mobile'] . '</td>';
        $html .= '<td dir="ltr">Test@1234</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    $html .= '<div class="links">';
    $html .= '<h3 style="margin-bottom: 15px;">🔗 لینک‌های مفید:</h3>';
    $html .= '<div class="link-item">🏠 <a href="http://localhost:8000" target="_blank">صفحه اصلی</a></div>';
    $html .= '<div class="link-item">🔐 <a href="http://localhost:8000/login" target="_blank">صفحه ورود</a></div>';
    $html .= '<div class="link-item">📊 <a href="http://localhost:8000/dashboard" target="_blank">داشبورد</a></div>';
    $html .= '</div>';

    echo '<script>showResults(' . json_encode($html) . ')</script>';

    echo '<script>log("🎉 تمام! تمام کاربران آماده هستند", "success")</script>';

} catch (\Exception $e) {
    echo '<script>log("❌ خطا: ' . htmlspecialchars($e->getMessage()) . '", "error")</script>';
    echo '<script>log("📍 فایل: ' . htmlspecialchars($e->getFile()) . ' (خط ' . $e->getLine() . ')", "error")</script>';
}

?>
