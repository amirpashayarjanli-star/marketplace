# 🔧 تست و رفع جریان‌های ثبتنام و ورود

این فایل شامل اسکریپت‌های تست و رفع تمام جریان‌های ثبتنام و ورود برای تمام نقش‌های کاربری است.

## 📋 فهرست

- [نقش‌های کاربری](#نقش‌های-کاربری)
- [اسکریپت‌های موجود](#اسکریپت‌های-موجود)
- [نحوه استفاده](#نحوه-استفاده)
- [تست‌های بررسی‌شده](#تست‌های-بررسی‌شده)
- [مشکلات احتمالی](#مشکلات-احتمالی)

---

## 🔑 نقش‌های کاربری

سیستم ۶ نوع کاربر را پشتیبانی می‌کند:

| نقش | توضیح | شماره تست |
|-----|------|---------|
| **Company** | شرکت آسانسوری | 09120000001 |
| **Technician** | تکنسین | 09120000002 |
| **Manufacturer** | تولیدکننده | 09120000003 |
| **Store** | فروشگاه | 09120000004 |
| **Employer** | کارفرما | 09120000005 |
| **Customer** | مشتری | 09120000006 |

**رمز عبور تمام کاربران تست**: `Test@1234`

---

## 📄 اسکریپت‌های موجود

### 1. `fix-auth-flow.bat` ✨ **برای Windows**

اسکریپت اصلی برای تست و رفع تمام جریان‌ها.

**مراحل اسکریپت:**
```
📦 مرحله 1: Backup دیتابیس
📋 مرحله 2: اجرای Migrations
🧪 مرحله 3: ایجاد Test Users
🗑️  مرحله 4: پاک کردن Cache
```

### 2. `tests/tinker-test-auth-flow.php` 🧪 **برای Tinker**

فایل PHP برای اجرا در محیط Tinker (تعاملی Artisan).

---

## 🚀 نحوه استفاده

### روش 1: اجرای اسکریپت Batch (توصیه‌شده برای Windows)

```bash
# از فولدر پروژه
cd D:\AsansorPRO\marketplace
fix-auth-flow.bat
```

### روش 2: استفاده از Tinker

```bash
# باز کردن Tinker
php artisan tinker

# اجرای اسکریپت
include('tests/tinker-test-auth-flow.php');
```

### روش 3: مراحل دستی

```bash
# 1. اجرای Migrations
php artisan migrate:fresh --force

# 2. باز کردن Tinker
php artisan tinker

# 3. اجرای این کد:
```

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'تست',
    'mobile' => '09120000001',
    'password' => Hash::make('Test@1234'),
    'type' => 'company',
    'status' => 'approved',
]);
```

---

## ✅ تست‌های بررسی‌شده

اسکریپت‌ها تمام موارد زیر را بررسی و تست می‌کنند:

### 1. **Registration Flow** ✓
- [x] ایجاد User با mobile و password
- [x] ذخیره‌ی موقت اطلاعات در Session
- [x] ایجاد OTP
- [x] تایید OTP
- [x] انتقال به انتخاب نقش

### 2. **Profile Wizard** ✓
- [x] انتخاب نوع (Type)
- [x] پر کردن اطلاعات پروفایل
- [x] ایجاد slug خودکار
- [x] ذخیره‌ی تمام فیلدها
- [x] تغییر status به pending

### 3. **Login Flow** ✓
- [x] ورود با mobile و password
- [x] بررسی status کاربر
- [x] هدایت به مسیر مناسب
  - Customer → Service Setup
  - دیگران → Dashboard
- [x] ورود برای تمام نقش‌ها

### 4. **Database** ✓
- [x] جداول پروفایل موجود
- [x] Foreign keys صحیح
- [x] Slug fields موجود
- [x] user_id fields موجود

---

## 🐛 مشکلات احتمالی و راه‌حل‌ها

### مشکل 1: خطای "Class not found"
```
Exception: Class not found
```
**راه‌حل:**
```bash
php artisan cache:clear
php artisan config:clear
composer dump-autoload
```

### مشکل 2: خطای "Database doesn't exist"
```bash
php artisan migrate:fresh --force
```

### مشکل 3: خطای OTP validation
**بررسی نکات:**
- فرمت شماره موبایل: `09XXXXXXXXX` (11 رقم)
- طول کد OTP: 5 رقم
- انقضای OTP: 5 دقیقه

### مشکل 4: Slug تکراری
**نوت:** Slug خودکار پسوند اضافه می‌کند:
```
name: "شرکت"
slug: "sherk" → "sherk-1" → "sherk-2"
```

---

## 📊 جریان‌های تفصیلی

### جریان Registration

```
User Goes to /register
    ↓
Enter Mobile + Password + Accept Terms
    ↓
Server validates & sends OTP
    ↓
User Sees /register/otp
    ↓
User Enters Code
    ↓
User Created with status='incomplete'
    ↓
Redirect to /profile/wizard/type
    ↓
Select Type (company, technician, etc.)
    ↓
Fill Profile Wizard Steps (4-6 steps)
    ↓
User Submits Profile
    ↓
Status Changes to 'pending'
    ↓
Admin Reviews & Approves
    ↓
Status Changes to 'approved'
    ↓
User Can Login & Access Dashboard
```

### جریان Login

```
User Goes to /login
    ↓
Enter Mobile + Password
    ↓
Server validates credentials
    ↓
Check user status:
    ├─ rejected → Error "حساب تایید نشد"
    ├─ incomplete/pending → Redirect to wizard
    ├─ approved (customer) → Redirect to service.index
    └─ approved (other) → Redirect to dashboard
```

---

## 🔐 اطلاعات کاربران تست

| نقش | موبایل | رمز |
|-----|--------|-----|
| Company | 09120000001 | Test@1234 |
| Technician | 09120000002 | Test@1234 |
| Manufacturer | 09120000003 | Test@1234 |
| Store | 09120000004 | Test@1234 |
| Employer | 09120000005 | Test@1234 |
| Customer | 09120000006 | Test@1234 |

---

## 🌐 لینک‌های تست

```
Home:       http://localhost:8000
Login:      http://localhost:8000/login
Dashboard:  http://localhost:8000/dashboard
Register:   http://localhost:8000/register
```

---

## 💡 نکات مهم

1. **تمام کاربران تست با `status='approved'` ایجاد می‌شوند**
   - این برای تست فوری بدون تایید ادمین است

2. **تمام پروفایل‌ها `is_active=true` دارند**
   - پروفایل‌ها در صفحات عمومی نمایش داده می‌شوند

3. **Slug خودکار تولید می‌شود**
   - از فیلد `name` استخراج می‌شود
   - اگر خالی باشد، یک slug تصادفی تولید می‌کند

4. **تمام email‌ها کاذب هستند**
   - `test_company@example.com` و غیره
   - برای تست واقعی، آن‌ها را تغییر دهید

---

## 🎯 Checklist تست کامل

- [ ] اسکریپت بدون خطا اجرا شد
- [ ] 6 کاربر تست ایجاد شدند
- [ ] می‌توانید از صفحه login وارد شوید
- [ ] بعد از ورود، به dashboard هدایت می‌شوید
- [ ] نام کاربر در هدر نمایش داده می‌شود
- [ ] می‌توانید از پروفایل کاربری اطلاعات دریافت کنید

---

## 📞 پشتیبانی

اگر مشکلی داشتید:

1. **لاگ‌های Artisan را بررسی کنید:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Database connection را تست کنید:**
   ```bash
   php artisan tinker
   DB::connection()->getPDO();
   ```

3. **Cache را پاک کنید:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

---

**آخرین بروزرسانی:** 2026-08-27
