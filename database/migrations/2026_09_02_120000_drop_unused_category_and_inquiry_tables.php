<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| حذف جدول‌های بی‌استفاده‌ی categories و inquiries
|--------------------------------------------------------------------------
|
| هر دو با make:model -m ساخته شده بودند و هیچ‌وقت پر نشدند: فقط id و
| timestamps داشتند، بدون حتی یک ستون واقعی. هیچ کدی از آن‌ها نمی‌خواند
| و در آن‌ها نمی‌نویسد و هر دو صفر ردیف دارند.
|
| کارِ واقعی‌شان جای دیگری انجام می‌شود:
|   دسته‌بندی → ستون متنی category روی products و auctions
|   استعلام   → جدول project_inquiries
|
| نگه‌داشتنشان یعنی اسکیما ادعای فیچری را می‌کند که وجود ندارد.
|
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('inquiries');
    }


    /**
     * برگرداندن به همان شکل توخالی که بودند — هیچ ستون دیگری نداشتند.
     */
    public function down(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
