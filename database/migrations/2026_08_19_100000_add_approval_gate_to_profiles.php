<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| دروازه‌ی نمایش پروفایل در سایت
|--------------------------------------------------------------------------
|
| قبلاً is_active پیش‌فرض true بود، یعنی پروفایل به محض ساخته شدن توی سایت
| بالا میومد و تایید ادمین هیچ ربطی به نمایش نداشت.
|
| از این به بعد:
|   is_active = false  → در سایت دیده نمیشه (حالت پیش‌فرض)
|   is_active = true   → فقط و فقط با تایید ادمین
|
| وضعیت کاربر هم یک مرحله‌ی جدید می‌گیره:
|   incomplete → هنوز پروفایلش رو کامل نکرده (پیش‌فرض ثبت‌نام)
|   pending    → کامل کرده، منتظر تایید ادمین
|   approved   → تایید شده، در سایت دیده میشه
|   rejected   → رد شده
|
*/

return new class extends Migration
{
    private array $profileTables = [
        'companies',
        'manufacturers',
        'stores',
        'technicians',
        'employers',
    ];


    public function up(): void
    {
        foreach ($this->profileTables as $table) {

            Schema::table($table, function (Blueprint $t) {

                $t->boolean('is_active')
                    ->default(false)
                    ->change();

            });


            // هر پروفایلی که تا الان ساخته شده هنوز تایید ادمین نگرفته،
            // پس تا زمان تایید از سایت برداشته میشه.
            DB::table($table)->update(['is_active' => false]);

        }


        Schema::table('users', function (Blueprint $t) {

            $t->string('status')
                ->default('incomplete')
                ->change();

        });


        // کاربرانی که پروفایلشون رو ناقص رها کردن به incomplete برمی‌گردن
        // تا مجبور بشن از داشبورد کاملش کنن. تاییدشده‌ها دست‌نخورده می‌مونن.
        DB::table('users')
            ->where('status', 'pending')
            ->update(['status' => 'incomplete']);
    }


    public function down(): void
    {
        foreach ($this->profileTables as $table) {

            Schema::table($table, function (Blueprint $t) {

                $t->boolean('is_active')
                    ->default(true)
                    ->change();

            });

        }


        Schema::table('users', function (Blueprint $t) {

            $t->string('status')
                ->default('pending')
                ->change();

        });
    }
};
