# ⚡ شروع سریع - تست تمام جریان‌های ثبتنام و ورود

## 🎯 خلاصه

این گاید شامل تمام چیزی است که برای تست کردن تمام نقش‌های کاربری (Company, Technician, Manufacturer, Store, Employer, Customer) نیاز دارید.

---

## 🚀 Step 1: اجرای اسکریپت (یک کلیک!)

### برای Windows - باتفاده از PowerShell:

```powershell
# در پوشه پروژه، PowerShell را باز کنید و:
powershell -ExecutionPolicy Bypass -File fix-auth-flow.ps1
```

### یا برای Command Prompt:

```cmd
cd D:\AsansorPRO\marketplace
fix-auth-flow.bat
```

### یا دستی - بدون اسکریپت:

```bash
# Step 1: میگریشن‌ها را اجرا کنید
php artisan migrate:fresh --force

# Step 2: کاربران تست را ایجاد کنید
php artisan tinker
```

سپس در Tinker کپی/پیسِت کنید:

```php
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

$user = User::create([
    'name' => 'شرکت تست',
    'mobile' => '09120000001',
    'password' => Hash::make('Test@1234'),
    'type' => 'company',
    'status' => 'approved',
]);

$company = Company::create([
    'user_id' => $user->id,
    'name' => 'شرکت تست',
    'phone' => '02112345678',
    'email' => 'test@example.com',
    'province' => 'تهران',
    'city' => 'تهران',
    'address' => 'خیابان تست، پلاک ۱۲۳',
    'description' => 'این یک پروفایل تست است با حداقل ۵۰ حرف برای پر کردن requirement.',
    'experience' => 5,
    'is_active' => true,
    'is_verified' => true,
]);

echo "✓ کاربر و پروفایل ایجاد شدند";
```

---

## 🌐 Step 2: باز کردن مرورگر

```
http://localhost:8000
```

اگر سرور داخل یک ترمینال دیگر در حال اجرا است، صفحه باید بارگیری شود.

---

## 🔐 Step 3: تست ورود

### برای هر نقش:

| نقش | شماره | رمز |
|-----|------|-----|
| Company | 09120000001 | Test@1234 |
| Technician | 09120000002 | Test@1234 |
| Manufacturer | 09120000003 | Test@1234 |
| Store | 09120000004 | Test@1234 |
| Employer | 09120000005 | Test@1234 |
| Customer | 09120000006 | Test@1234 |

### مراحل:

1. به `http://localhost:8000/login` بروید
2. شماره موبایل را وارد کنید (مثلاً 09120000001)
3. رمز عبور را وارد کنید: `Test@1234`
4. دکمه "ورود" را فشار دهید
5. ✓ باید به داشبورد هدایت شوید

---

## ✅ چه چیزهایی تست می‌شوند؟

### 1. **ثبتنام (Registration)**
- [x] ورود شماره موبایل و رمز عبور
- [x] تایید OTP
- [x] ایجاد کاربر
- [x] انتقال به انتخاب نقش

### 2. **ویزارد پروفایل (Profile Wizard)**
- [x] انتخاب نوع
- [x] پر کردن اطلاعات
- [x] ذخیره‌ی slider‌ها
- [x] ارسال برای تایید

### 3. **ورود (Login)**
- [x] تمام نقش‌ها
- [x] بررسی وضعیت کاربر
- [x] هدایت مناسب

### 4. **داشبورد (Dashboard)**
- [x] دسترسی برای تمام نقش‌های تایید‌شده
- [x] نمایش نام کاربر
- [x] نمایش پروفایل

---

## 🔧 اگر مشکل پیدا کردید

### خطای "Migrate" یا "Database"

```bash
# 1. دیتابیس را پاک کنید و دوباره ایجاد کنید
php artisan migrate:fresh --force

# 2. Cache را پاک کنید
php artisan cache:clear
php artisan config:clear
```

### خطای "Class Not Found"

```bash
# Autoload را تازه‌سازی کنید
composer dump-autoload
```

### خطای ورود

**بررسی نکات:**
- ✓ شماره موبایل درست باشد (09XXXXXXXXX)
- ✓ رمز عبور درست باشد (Test@1234)
- ✓ کاربر در دیتابیس وجود داشته باشد
- ✓ وضعیت کاربر "approved" باشد

---

## 📂 فایل‌های مرتبط

```
marketplace/
├── fix-auth-flow.bat              ← اسکریپت Windows
├── fix-auth-flow.ps1              ← اسکریپت PowerShell
├── FIX-AUTH-FLOW-README.md         ← توضیحات کامل
├── QUICK-START.md                  ← این فایل
└── tests/
    └── tinker-test-auth-flow.php   ← اسکریپت Tinker
```

---

## 📝 نکات مهم

### 1. **Status اهمیت دارد**
```
incomplete  → کاربر جدید، نیاز به تکمیل پروفایل
pending     → پروفایل ارسال شده، منتظر تایید
approved    → تایید شده، دسترسی کامل
rejected    → رد شده، نمی‌تواند وارد شود
```

### 2. **Slug خودکار تولید می‌شود**
```php
name: "شرکت آسانسوری"
↓
slug: "sherk-asansori" (یا اگر تکراری: "sherk-asansori-1")
```

### 3. **هر نقش متفاوت است**
- **Company**: نام شرکت، مدیر، تجربه
- **Technician**: نام، مهارت‌ها، تجربه
- **Manufacturer**: نام، تولیدات، تجربه
- **Store**: نام فروشگاه، محصولات
- **Employer**: نام کارفرما، پروژه‌ها
- **Customer**: مشتری ساده، بدون پروفایل پیچیده

---

## 🎓 مثال کامل: ایجاد کاربر Company

```bash
# ترمینال باز کنید:
php artisan tinker

# سپس:
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

# کاربر ایجاد کنید:
$user = User::create([
    'name' => 'شرکت رایحه',
    'mobile' => '09120000001',
    'password' => Hash::make('Test@1234'),
    'type' => 'company',
    'status' => 'approved',
]);

# پروفایل ایجاد کنید:
$company = Company::create([
    'user_id' => $user->id,
    'name' => 'شرکت رایحه',
    'manager_name' => 'مهندس علی',
    'phone' => '02112345678',
    'email' => 'info@rayehe.com',
    'website' => 'https://rayehe.com',
    'province' => 'تهران',
    'city' => 'تهران',
    'address' => 'خیابان فردوسی، خیابان شریعتی، پلاک ۱۲۳',
    'description' => 'شرکت رایحه یکی از پیشرو‌ترین شرکت‌های آسانسوری در ایران است که با بیش از ۲۰ سال تجربه خدمات باکیفیت ارائه می‌دهد.',
    'experience' => 20,
    'is_active' => true,
    'is_verified' => true,
]);

# ورود کنید:
auth()->login($user);

# نتایج چک کنید:
$user->company->name;        # "شرکت رایحه"
$user->company->slug;        # "sherk-rayehe"
auth()->user()->name;        # "شرکت رایحه"
```

---

## ❓ سوالات متداول

**س: آیا می‌توانم رمز عبور را تغییر دهم؟**
پ: بله، از داشبورد → تنظیمات → تغییر رمز عبور

**س: آیا می‌توانم پروفایل را ویرایش کنم؟**
پ: بله، اگر وضعیت pending یا incomplete باشد. اگر approved است، نمی‌توانید بدون دوباره ارسال برای تایید.

**س: اگر OTP منقضی شد، چی کار کنم؟**
پ: دوباره "ارسال مجدد کد" را فشار دهید یا از اول ثبتنام کنید.

**س: پروفایل چطوری در سایت نمایش داده می‌شود؟**
پ: فقط اگر `is_active=true` و `status=approved` و `is_verified=true` باشد.

---

## 🎉 بعدی چی؟

بعد از اینکه تمام چیزها کار می‌کند:

1. **خود را ایجاد کنید** - ثبتنام برای واقعی
2. **پروفایل کامل کنید** - تمام فیلدهای الزامی را پر کنید
3. **تست قابلیت‌های دیگر** - پروژه‌ها، سرویس‌ها، etc.
4. **محتوای تست اضافی ایجاد کنید**

---

**سوال دارید؟ به `FIX-AUTH-FLOW-README.md` مراجعه کنید!**
