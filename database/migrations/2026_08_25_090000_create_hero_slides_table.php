<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| اسلایدهای هیرو — کاملاً از پنل مدیریت قابل تنظیم.
| مدیر می‌تونه تصویر، متن، دکمه و مقصد لینک رو عوض کنه بدون
| اینکه به کد دست بزنه.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {

            $table->id();

            $table->string('image');

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();

            // دکمه‌ی روی اسلاید — اگر متن نداشته باشه، دکمه نمایش داده نمیشه
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();

            // ترتیب نمایش؛ کوچک‌تر یعنی جلوتر
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['is_active', 'sort_order']);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
