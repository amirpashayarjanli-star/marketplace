# راهنمای انتقال آسانسور پرو به هاست اشتراکی (cPanel)

## پیش‌نیازها روی هاست

قبل از هر چیز از پشتیبانی هاست بپرس یا در cPanel چک کن:
- ✅ نسخهٔ PHP باید **8.2 یا بالاتر** باشد (ترجیحاً 8.4)
- ✅ Extension های لازم: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`
- ✅ دسترسی به **MySQL Databases**

برای چک کردن نسخهٔ PHP: در cPanel دنبال **"MultiPHP Manager"** یا **"Select PHP Version"** بگرد.

---

## سناریو A: اگر SSH/Terminal داری (توصیه‌شده)

### 1. آپلود کد
از طریق SSH به سرور وصل شو و کد رو clone یا آپلود کن:
```bash
cd ~
git clone <your-repo-url> asansor-pro
cd asansor-pro
```

اگر Git روی هاست نصب نیست، فایل‌ها رو با File Manager یا FTP از حالت zip آپلود کن (بدون `node_modules` و `vendor` — اینها رو خودمون می‌سازیم).

### 2. نصب Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

> اگر `npm`/`node` روی هاست نیست، فولدر `public/build/` رو از سیستم خودت (که از قبل build شده) آپلود کن — نیازی به اجرای `npm run build` روی هاست نیست.

### 3. تنظیم .env
```bash
cp .env.production.example .env
nano .env   # یا از File Manager ادیت کن
```

مقادیر زیر رو با اطلاعات واقعی هاست پر کن:
```
APP_URL=https://yourdomain.com
DB_HOST=localhost
DB_DATABASE=yourcpanel_asansorpro
DB_USERNAME=yourcpanel_dbuser
DB_PASSWORD=your_db_password
```

> **نکته مهم:** در اکثر هاست‌های اشتراکی ایرانی، نام دیتابیس و یوزر با پیشوند نام‌کاربری cPanel شروع می‌شه (مثلاً `username_asansorpro`).

### 4. ساخت APP_KEY
```bash
php artisan key:generate
```

### 5. اجرای Migration
```bash
php artisan migrate --force
php artisan db:seed --force   # اختیاری، برای داده‌های نمونه
```

### 6. Cache و Optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. تنظیم Document Root روی `public/`
این مهم‌ترین قدم است! چون cPanel به طور پیش‌فرض `public_html/` رو serve می‌کنه، ولی Laravel باید از `public_html/public/` سرو بشه.

**دو راه داری:**

**راه ۱ (ساده‌تر):** پروژه رو خارج از `public_html` آپلود کن (مثلاً در `~/asansor-pro`)، بعد محتویات پوشهٔ `public/` رو داخل `public_html` کپی کن، و در `index.php` که داخل `public_html` هست مسیرها رو اصلاح کن:

```php
// در public_html/index.php این خطوط رو پیدا کن و اصلاح کن:
require __DIR__.'/../asansor-pro/vendor/autoload.php';
$app = require_once __DIR__.'/../asansor-pro/bootstrap/app.php';
```

**راه ۲ (اگر امکانش هست):** از cPanel بخواه Document Root دامنه‌ت رو مستقیم به `asansor-pro/public` تنظیم کنه (بعضی هاست‌ها این امکان رو در "Domains" یا "Addon Domains" میدن).

### 8. تنظیم Permissions
```bash
chmod -R 775 storage bootstrap/cache
```

### 9. تست
آدرس سایتت رو باز کن و چک کن که کار می‌کنه.

---

## سناریو B: اگر SSH نداری (فقط File Manager / FTP)

این حالت سخت‌تره چون نمی‌تونی `composer install` یا `artisan` رو مستقیم روی سرور اجرا کنی.

### 1. آماده‌سازی کامل روی سیستم خودت (قبل از آپلود)
```bash
composer install --no-dev --optimize-autoloader
npm run build
```
این کار `vendor/` و `public/build/` رو محلی می‌سازه.

### 2. ساخت APP_KEY محلی
```bash
php artisan key:generate --show
```
این یک مقدار مثل `base64:xxxxx` بهت میده — کپی کن، بعداً لازمش داری.

### 3. آپلود کامل پروژه (شامل vendor و public/build)
تمام فایل‌ها رو (به جز `.git`, `node_modules`) zip کن و از طریق File Manager آپلود و extract کن.

### 4. ساخت دیتابیس MySQL از cPanel
- به بخش **"MySQL Databases"** برو
- یک دیتابیس بساز (مثلاً `username_asansorpro`)
- یک یوزر بساز و به دیتابیس متصلش کن با تمام دسترسی‌ها

### 5. ساخت فایل .env از File Manager
یک فایل `.env` در ریشهٔ پروژه بساز و این محتوا رو (با مقادیر واقعی خودت) داخلش بریز:
```env
APP_NAME="آسانسور پرو"
APP_ENV=production
APP_KEY=base64:xxxxx   ← همونی که در قدم 2 گرفتی
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_asansorpro
DB_USERNAME=username_dbuser
DB_PASSWORD=your_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="آسانسور پرو"

MELIPAYAMAK_USERNAME=your_username
MELIPAYAMAK_PASSWORD=your_password
MELIPAYAMAK_NUMBER=your_number
```

### 6. اجرای Migration بدون SSH
چون artisan نمی‌تونی اجرا کنی، دو راه داری:
- **راه ساده:** از هاستت بخواه یک بار SSH موقت بهت بده (خیلی از هاست‌ها این امکان رو دارن)
- **راه جایگزین:** فایل SQL دیتابیس رو محلی export کن (`php artisan migrate` رو لوکال روی MySQL بزن، بعد dump بگیر) و از **phpMyAdmin** توی cPanel وارد (import) کن

### 7. تنظیم Document Root (مثل سناریو A، قدم ۷)

### 8. Permissions از File Manager
روی پوشه‌های `storage` و `bootstrap/cache` راست‌کلیک کن → Permissions → روی **755** یا **775** تنظیم کن.

---

## چک‌لیست نهایی بعد از آپلود

- [ ] سایت باز میشه بدون خطای 500
- [ ] صفحهٔ login و register درست نمایش داده میشن
- [ ] عکس‌ها و لوگو لود میشن
- [ ] فرم ثبت‌نام کار می‌کنه (تست با شماره واقعی)
- [ ] پیامک OTP ارسال میشه (یعنی Melipayamak درست تنظیم شده)
- [ ] `APP_DEBUG=false` هست (یعنی خطاها رو کاربر نمی‌بینه)
- [ ] SSL (قفل سبز/https) فعاله

---

## مشکلات رایج

**خطای 500 بعد از آپلود:**
- چک کن `storage/` و `bootstrap/cache/` قابل نوشتن هستن (permission 775)
- چک کن `.env` درست ساخته شده و `APP_KEY` خالی نیست

**صفحه سفید (White Screen):**
- `APP_DEBUG=true` رو موقتاً فعال کن تا خطا رو ببینی، بعد دوباره `false` کن

**CSS/JS لود نمیشه:**
- چک کن `public/build/` آپلود شده و مسیرش درسته

**اتصال به دیتابیس برقرار نمیشه:**
- `DB_HOST` رو بعضی هاست‌ها به‌جای `localhost` مقدار متفاوتی میخوان (از پشتیبانی بپرس)
