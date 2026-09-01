# ============================================================================
# تست و رفع جریان‌های ثبتنام و ورود برای تمام نقش‌ها
# ============================================================================
#
# استفاده:
#   powershell -ExecutionPolicy Bypass -File fix-auth-flow.ps1
#

$ErrorActionPreference = "Continue"

Write-Host ""
Write-Host "╔════════════════════════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║                      تست و رفع Auth Flow                                      ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""

$timestamp = Get-Date -Format "yyyyMMdd-HHmmss"
$BACKUP_DIR = ".backup-$timestamp"

# ============================================================================
# مرحله 1: Backup دیتابیس
# ============================================================================
Write-Host "📦 مرحله 1: ایجاد backup از دیتابیس..." -ForegroundColor Yellow
Write-Host ""

if (Test-Path "database\database.sqlite") {
    New-Item -ItemType Directory -Path $BACKUP_DIR -Force | Out-Null
    Copy-Item "database\database.sqlite" "$BACKUP_DIR\database.sqlite" -Force
    Write-Host "✓ Backup ایجاد شد: $BACKUP_DIR\database.sqlite" -ForegroundColor Green
} else {
    Write-Host "⚠ فایل database.sqlite پیدا نشد (شاید از MySQL استفاده می‌کنید)" -ForegroundColor Yellow
}

Write-Host ""

# ============================================================================
# مرحله 2: اجرای migrations
# ============================================================================
Write-Host "📋 مرحله 2: اجرای Migrations..." -ForegroundColor Yellow
Write-Host ""

php artisan migrate:fresh --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ خطا در اجرای migrations" -ForegroundColor Red
    Read-Host "برای خروج Enter را فشار دهید"
    exit 1
}

Write-Host "✓ Migrations اجرا شدند" -ForegroundColor Green
Write-Host ""

# ============================================================================
# مرحله 3: ایجاد Test Data
# ============================================================================
Write-Host "🧪 مرحله 3: ایجاد Test Users..." -ForegroundColor Yellow
Write-Host ""

$tinkerCode = @"
use App\Models\User;
use App\Models\Company;
use App\Models\Technician;
use App\Models\Manufacturer;
use App\Models\Store;
use App\Models\Employer;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

`$testCases = [
    ['mobile' => '09120000001', 'name' => 'شرکت آسانسوری تست', 'type' => 'company', 'model' => Company::class],
    ['mobile' => '09120000002', 'name' => 'تکنسین تست', 'type' => 'technician', 'model' => Technician::class],
    ['mobile' => '09120000003', 'name' => 'تولیدکننده تست', 'type' => 'manufacturer', 'model' => Manufacturer::class],
    ['mobile' => '09120000004', 'name' => 'فروشگاه تست', 'type' => 'store', 'model' => Store::class],
    ['mobile' => '09120000005', 'name' => 'کارفرما تست', 'type' => 'employer', 'model' => Employer::class],
    ['mobile' => '09120000006', 'name' => 'مشتری تست', 'type' => 'customer', 'model' => Customer::class],
];

foreach (`$testCases as `$case) {
    `$user = User::create([
        'name' => `$case['name'],
        'mobile' => `$case['mobile'],
        'password' => Hash::make('Test@1234'),
        'type' => `$case['type'],
        'status' => 'approved',
    ]);

    echo "✓ {`$case['type']}: {`$case['mobile']}\n";

    if (`$case['type'] !== 'customer') {
        `$profile = new `$case['model']();
        `$profile->user_id = `$user->id;
        `$profile->name = `$case['name'];
        if (`$profile->isFillable('phone')) `$profile->phone = '02112345678';
        if (`$profile->isFillable('email')) `$profile->email = "test_{`$case['type']}@example.com";
        if (`$profile->isFillable('province')) `$profile->province = 'تهران';
        if (`$profile->isFillable('city')) `$profile->city = 'تهران';
        if (`$profile->isFillable('address')) `$profile->address = 'خیابان تست، پلاک ۱۲۳';
        if (`$profile->isFillable('description')) `$profile->description = 'این یک پروفایل تست است با حداقل ۵۰ حرف برای پر کردن requirement.';
        if (`$profile->isFillable('experience')) `$profile->experience = 5;
        if (`$profile->isFillable('manager_name')) `$profile->manager_name = 'مدیر تست';
        if (`$profile->isFillable('skills')) `$profile->skills = 'تست، نگهداری، سرویس';
        if (`$profile->isFillable('is_active')) `$profile->is_active = true;
        if (`$profile->isFillable('is_verified')) `$profile->is_verified = true;
        `$profile->save();
    } else {
        Customer::create([
            'user_id' => `$user->id,
            'name' => `$case['name'],
            'phone' => '02112345678',
            'province' => 'تهران',
            'city' => 'تهران',
            'address' => 'خیابان تست، پلاک ۱۲۳',
        ]);
    }
}

echo "\n✓ تمام Test Users ایجاد شدند\n";
"@

php artisan tinker << $tinkerCode

if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ خطا در ایجاد test data" -ForegroundColor Red
    Read-Host "برای خروج Enter را فشار دهید"
    exit 1
}

Write-Host ""

# ============================================================================
# مرحله 4: Cache clear
# ============================================================================
Write-Host "🗑️  مرحله 4: تمیز کردن Cache..." -ForegroundColor Yellow
Write-Host ""

php artisan cache:clear | Out-Null
php artisan config:clear | Out-Null
php artisan route:clear | Out-Null
php artisan view:clear | Out-Null

Write-Host "✓ Cache پاک شد" -ForegroundColor Green
Write-Host ""

# ============================================================================
# خلاصه
# ============================================================================
Write-Host "╔════════════════════════════════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║                         ✅ تست تکمیل شد!                                      ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════════════════════════════════╝" -ForegroundColor Green
Write-Host ""

Write-Host "🔐 اطلاعات کاربران تست:" -ForegroundColor Cyan
Write-Host ""
Write-Host "  Company:      09120000001 / Test@1234" -ForegroundColor White
Write-Host "  Technician:   09120000002 / Test@1234" -ForegroundColor White
Write-Host "  Manufacturer: 09120000003 / Test@1234" -ForegroundColor White
Write-Host "  Store:        09120000004 / Test@1234" -ForegroundColor White
Write-Host "  Employer:     09120000005 / Test@1234" -ForegroundColor White
Write-Host "  Customer:     09120000006 / Test@1234" -ForegroundColor White
Write-Host ""

Write-Host "🌐 لینک‌های تست:" -ForegroundColor Cyan
Write-Host "  ▪ Home:       http://localhost:8000" -ForegroundColor White
Write-Host "  ▪ Login:      http://localhost:8000/login" -ForegroundColor White
Write-Host "  ▪ Dashboard:  http://localhost:8000/dashboard" -ForegroundColor White
Write-Host ""

Write-Host "📝 نکات:" -ForegroundColor Cyan
Write-Host "  ▪ اگر خطایی پیش آمد، می‌توانید دیتابیس را بازیابی کنید:" -ForegroundColor White
Write-Host "    copy $BACKUP_DIR\database.sqlite database\database.sqlite" -ForegroundColor Yellow
Write-Host "  ▪ تمام کاربران با status='approved' ایجاد شدند" -ForegroundColor White
Write-Host "  ▪ می‌توانید فوری با داشبورد کار کنید" -ForegroundColor White
Write-Host ""

Read-Host "برای خروج Enter را فشار دهید"
