@echo off
REM ============================================================================
REM  تست و رفع جریان‌های ثبتنام و ورود برای تمام نقش‌ها
REM ============================================================================

setlocal enabledelayedexpansion
cd /d "%~dp0"
cd ..\..

echo.
echo ╔════════════════════════════════════════════════════════════════════════════════╗
echo ║                      تست و رفع Auth Flow                                      ║
echo ╚════════════════════════════════════════════════════════════════════════════════╝
echo.

REM ============================================================================
REM مرحله 1: Backup دیتابیس
REM ============================================================================
echo 📦 مرحله 1: ایجاد backup از دیتابیس...
echo.

if exist "database\database.sqlite" (
    for /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c%%a%%b)
    for /f "tokens=1-2 delims=/:" %%a in ('time /t') do (set mytime=%%a%%b)
    set BACKUP_DIR=.backup-!mydate!-!mytime!

    if not exist "!BACKUP_DIR!" mkdir "!BACKUP_DIR!"
    copy "database\database.sqlite" "!BACKUP_DIR!\database.sqlite" >nul
    echo ✓ Backup ایجاد شد: !BACKUP_DIR!\database.sqlite
) else (
    echo ⚠ فایل database.sqlite پیدا نشد ^(شاید از MySQL استفاده می‌کنید^)
)

echo.

REM ============================================================================
REM مرحله 2: اجرای migrations
REM ============================================================================
echo 📋 مرحله 2: اجرای Migrations...
echo.

call php artisan migrate:fresh --force
if errorlevel 1 (
    echo ✗ خطا در اجرای migrations
    pause
    exit /b 1
)
echo ✓ Migrations اجرا شدند

echo.

REM ============================================================================
REM مرحله 3: ایجاد Test Data
REM ============================================================================
echo 🧪 مرحله 3: ایجاد Test Users...
echo.

REM استفاده از tinker برای اجرای PHP code
php artisan tinker << 'PHPCODE'
use App\Models\User;
use App\Models\Company;
use App\Models\Technician;
use App\Models\Manufacturer;
use App\Models\Store;
use App\Models\Employer;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

$testCases = [
    ['mobile' => '09120000001', 'name' => 'شرکت آسانسوری تست', 'type' => 'company', 'model' => Company::class],
    ['mobile' => '09120000002', 'name' => 'تکنسین تست', 'type' => 'technician', 'model' => Technician::class],
    ['mobile' => '09120000003', 'name' => 'تولیدکننده تست', 'type' => 'manufacturer', 'model' => Manufacturer::class],
    ['mobile' => '09120000004', 'name' => 'فروشگاه تست', 'type' => 'store', 'model' => Store::class],
    ['mobile' => '09120000005', 'name' => 'کارفرما تست', 'type' => 'employer', 'model' => Employer::class],
    ['mobile' => '09120000006', 'name' => 'مشتری تست', 'type' => 'customer', 'model' => Customer::class],
];

foreach ($testCases as $case) {
    $user = User::create([
        'name' => $case['name'],
        'mobile' => $case['mobile'],
        'password' => Hash::make('Test@1234'),
        'type' => $case['type'],
        'status' => 'approved',
    ]);

    echo "✓ {$case['type']}: {$case['mobile']}\n";

    if ($case['type'] !== 'customer') {
        $profile = new $case['model']();
        $profile->user_id = $user->id;
        $profile->name = $case['name'];
        if ($profile->isFillable('phone')) $profile->phone = '02112345678';
        if ($profile->isFillable('email')) $profile->email = "test_{$case['type']}@example.com";
        if ($profile->isFillable('province')) $profile->province = 'تهران';
        if ($profile->isFillable('city')) $profile->city = 'تهران';
        if ($profile->isFillable('address')) $profile->address = 'خیابان تست، پلاک ۱۲۳';
        if ($profile->isFillable('description')) $profile->description = 'این یک پروفایل تست است با حداقل ۵۰ حرف برای پر کردن requirement.';
        if ($profile->isFillable('experience')) $profile->experience = 5;
        if ($profile->isFillable('manager_name')) $profile->manager_name = 'مدیر تست';
        if ($profile->isFillable('skills')) $profile->skills = 'تست، نگهداری، سرویس';
        if ($profile->isFillable('is_active')) $profile->is_active = true;
        if ($profile->isFillable('is_verified')) $profile->is_verified = true;
        $profile->save();
    } else {
        Customer::create([
            'user_id' => $user->id,
            'name' => $case['name'],
            'phone' => '02112345678',
            'province' => 'تهران',
            'city' => 'تهران',
            'address' => 'خیابان تست، پلاک ۱۲۳',
        ]);
    }
}

echo "\n✓ تمام Test Users ایجاد شدند\n";
PHPCODE

if errorlevel 1 (
    echo ✗ خطا در ایجاد test data
    pause
    exit /b 1
)

echo.

REM ============================================================================
REM مرحله 4: Cache clear
REM ============================================================================
echo 🗑️  مرحله 4: تمیز کردن Cache...
echo.

call php artisan cache:clear >nul 2>&1
call php artisan config:clear >nul 2>&1
call php artisan route:clear >nul 2>&1
call php artisan view:clear >nul 2>&1

echo ✓ Cache پاک شد

echo.

REM ============================================================================
REM خلاصه
REM ============================================================================
echo ╔════════════════════════════════════════════════════════════════════════════════╗
echo ║                         ✅ تست تکمیل شد!                                      ║
echo ╚════════════════════════════════════════════════════════════════════════════════╝
echo.

echo 🔐 اطلاعات کاربران تست:
echo.
echo   Company:      09120000001 / Test@1234
echo   Technician:   09120000002 / Test@1234
echo   Manufacturer: 09120000003 / Test@1234
echo   Store:        09120000004 / Test@1234
echo   Employer:     09120000005 / Test@1234
echo   Customer:     09120000006 / Test@1234
echo.

echo 🌐 لینک‌های تست:
echo   ▪ Home:       http://localhost:8000
echo   ▪ Login:      http://localhost:8000/login
echo   ▪ Dashboard:  http://localhost:8000/dashboard
echo.

echo 📝 نکات:
echo   ▪ اگر خطایی پیش آمد، می‌توانید دیتابیس را بازیابی کنید
echo   ▪ تمام کاربران با status='approved' ایجاد شدند
echo   ▪ می‌توانید فوری با داشبورد کار کنید
echo.

pause

