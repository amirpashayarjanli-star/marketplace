# آسانسور پرو - Asansor Pro

یک پلتفرم بازار قدرتمند برای صنعت آسانسورهای ایران

## 🎯 درباره پروژه

آسانسور پرو یک پلتفرم تخصصی برای اتصال شرکت‌های آسانسوری، تولیدکنندگان، فروشگاه‌ها، تکنسین‌ها و کارفرمایان در یک اکوسیستم واحد است.

**ویژگی‌های اصلی:**
- 🏢 ثبت و مدیریت شرکت‌های آسانسوری
- 🏭 پلتفرم تولیدکنندگان
- 🛍️ بازار آنلاین برای فروشگاه‌ها
- 👨‍🔧 شبکه تکنسین‌های متخصص
- 📋 سامانه پروژه‌ها و درخواست‌ها
- ⭐ سیستم نقاط و نظرات کاربران
- 📱 رابط‌کاربری فارسی و responsive

## 📋 پیش‌نیازها

- PHP 8.4+
- Laravel 13
- MySQL 8.0+ (یا SQLite برای development)
- Node.js 18+ (برای Vite)
- Composer

## 🚀 نصب و راه‌اندازی

### 1. کلون پروژه
```bash
git clone https://github.com/yourusername/asansor-pro.git
cd asansor-pro
```

### 2. نصب وابستگی‌ها
```bash
composer install
npm install
```

### 3. تنظیم Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. پایگاه داده
```bash
php artisan migrate --seed
```

### 5. Build Assets
```bash
npm run dev
```

### 6. راه‌اندازی سرور
```bash
php artisan serve
```

سایت در `http://localhost:8000` دسترسی‌پذیر است.

## 📦 Vite Development Server

برای development با hot reload:
```bash
npm run dev
```

برای production build:
```bash
npm run build
```

## 🗄️ ساختار پایگاه داده

### جداول اصلی:
- `users` - کاربران سیستم
- `companies` - شرکت‌های آسانسوری
- `manufacturers` - تولیدکنندگان
- `stores` - فروشگاه‌ها
- `technicians` - تکنسین‌ها
- `projects` - پروژه‌ها
- `reviews` - نقاط و نظرات
- `otp_codes` - کدهای تایید

## 🔐 امنیت

### ویژگی‌های امنیتی:
- ✅ CSRF Protection
- ✅ User Approval System
- ✅ Role-Based Authorization
- ✅ Rate Limiting on Auth Routes
- ✅ Input Validation & Sanitization
- ✅ Secure Password Hashing (bcrypt)
- ✅ Session Encryption
- ✅ SQL Injection Protection (Eloquent ORM)

### متغیرهای Environment حساس:
- `APP_KEY` - رمز رمزگذاری
- `DB_PASSWORD` - رمز پایگاه داده
- `MELIPAYAMAK_USERNAME` - اعتبارات SMS
- `MELIPAYAMAK_PASSWORD` - اعتبارات SMS
- `MAIL_PASSWORD` - رمز ایمیل

**⚠️ هرگز این متغیرها را در repo commits نکنید!**

## 📱 نوع کاربران

1. **Company (شرکت)**
   - ثبت خدمات آسانسوری
   - مدیریت پروژه‌ها
   - دریافت درخواست‌های همکاری

2. **Manufacturer (تولیدکننده)**
   - فهرست محصولات
   - مدیریت پروژه‌ها
   - ارتباط با شرکت‌ها

3. **Store (فروشگاه)**
   - فروش قطعات و تجهیزات
   - مدیریت موجودی
   - خدمات تکمیلی

4. **Technician (تکنسین)**
   - اعلام دسترس‌پذیری برای پروژه‌ها
   - مدیریت تاریخچهٔ کار
   - دریافت درخواست‌ها

5. **Employer (کارفرما)**
   - ثبت پروژه‌ها
   - دریافت پیشنهادات
   - مدیریت قرارداد‌ها

## 🛠️ تنظیمات تولید

### قبل از Deploy:

1. **تنظیم Environment:**
   ```bash
   cp .env.production.example .env
   # تکمیل تمام متغیرها
   ```

2. **تنظیم پایگاه داده:**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

3. **Cache و Optimization:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

4. **Assets:**
   ```bash
   npm run build
   php artisan assets:publish
   ```

5. **Permissions:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data /var/www/asansor-pro
   ```

### Nginx Configuration:
```nginx
server {
    listen 443 ssl http2;
    server_name your-domain.com;
    
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    root /var/www/asansor-pro/public;
    index index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/run/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

## 📚 API Routes

### Public Routes:
- `GET /` - صفحه اصلی
- `GET /companies` - لیست شرکت‌ها
- `GET /manufacturers` - لیست تولیدکنندگان
- `GET /stores` - لیست فروشگاه‌ها
- `GET /technicians` - لیست تکنسین‌ها
- `GET /projects` - لیست پروژه‌ها

### Auth Routes:
- `POST /login` - ورود
- `POST /login/otp` - ورود با OTP
- `POST /register` - ثبت‌نام
- `POST /register/otp` - تایید OTP

### Protected Routes:
- `GET /dashboard` - صفحهٔ داشبورد
- `GET /dashboard/profile` - پروفایل کاربر
- `POST /dashboard/profile` - بروزرسانی پروفایل

## 🧪 Testing

```bash
php artisan test
```

## 📊 Monitoring

بررسی logs:
```bash
tail -f storage/logs/laravel.log
```

## 🤝 Contributing

برای مشارکت:
1. Fork پروژه
2. ایجاد Branch جدید
3. Commit تغییرات
4. Push و Pull Request

## 📞 پشتیبانی

برای گزارش مسائل یا پیشنهادات، لطفاً GitHub Issues رو استفاده کنید.

## 📄 License

این پروژه تحت MIT License است.

## 👥 نویسندگان

- **Amir Pasha Yarjanli** - توسعه‌دهندهٔ اصلی

---

**ساخت شده با ❤️ برای صنعت آسانسورهای ایران**
