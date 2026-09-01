<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| پروفایل «مشتری» — کسی که ساختمان/آسانسورش خراب میشه و برای پروسرویس
| ثبت‌نام می‌کنه. برخلاف company/technician/store/manufacturer، این پروفایل
| هیچ‌وقت در دایرکتوری عمومی سایت نمایش داده نمیشه، پس نیازی به
| is_active/is_verified یا تایید ادمین برای «نمایش» نداره.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('mobile', 20)->nullable();

            $table->string('phone', 30)->nullable();

            $table->string('province')->nullable();

            $table->string('city')->nullable();

            $table->text('address')->nullable();

            // تکنسین ثابت مشتری — هر خرابی جدید پیش‌فرض برای همین تکنسین می‌ره
            $table->foreignId('dedicated_technician_id')
                ->nullable()
                ->constrained('technicians')
                ->nullOnDelete();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
