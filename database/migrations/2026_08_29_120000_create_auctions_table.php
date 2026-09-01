<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('auctions', function (Blueprint $table) {

            $table->id();

            $table->string('slug')->unique();

            // منبع: onsite = کارفرمای سایت ساخته | external = ادمین از سامانه ستاد آورده
            $table->string('source')->default('onsite');

            // پروژه‌ی مرتبط (اختیاری) و کارفرمای صاحب مزایده
            // برای مناقصه‌های ستاد، کارفرما نداریم پس nullable است.
            $table->foreignId('project_id')
                ->nullable()
                ->constrained('projects')
                ->nullOnDelete();

            $table->foreignId('employer_id')
                ->nullable()
                ->constrained('employers')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            // نوع کار: نصب / مدرن‌سازی / سرویس و نگهداری / تامین تجهیزات
            $table->string('scope')->default('install');

            $table->string('province')->nullable();
            $table->string('city')->nullable();

            /*
            | فیلدهای مخصوص مناقصه‌های سامانه ستاد (source = external)
            */
            $table->string('tender_no')->nullable();       // شماره فراخوان
            $table->string('organization')->nullable();    // دستگاه مناقصه‌گزار
            $table->string('category')->nullable();        // طبقه‌بندی موضوعی
            $table->string('source_url')->nullable();      // لینک صفحه‌ی ستاد
            $table->timestamp('published_at')->nullable(); // تاریخ انتشار در ستاد

            // سقف بودجه‌ی کارفرما (اختیاری)
            $table->unsignedBigInteger('budget_max')->nullable();

            // مشخصات فنی آزاد (تعداد توقف، ظرفیت، ...)
            $table->json('specs')->nullable();

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            $table->unsignedSmallInteger('anti_snipe_minutes')
                ->default(config('proauction.anti_snipe_minutes', 10));

            // draft → pending_review → active → closed → awarded / cancelled
            $table->string('status')->default('draft');

            // FK واقعی نیست تا وابستگی حلقه‌ای auctions↔bids پیش نیاید؛
            // یکپارچگی‌اش در کد (award/cancel) نگه داشته می‌شود.
            $table->unsignedBigInteger('winner_bid_id')->nullable();

            // درصد کارمزد، کش‌شده از config در لحظه‌ی ساخت
            $table->decimal('fee_percent', 5, 2)
                ->default(config('proauction.fee_percent', 5));

            // آیا ثبت پیشنهاد روی سایت برای این مزایده باز است؟
            $table->boolean('bids_enabled')->default(true);

            // زمان ارسال پیامک اطلاع‌رسانی به شرکت‌ها (null = هنوز ارسال نشده)
            $table->timestamp('notified_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'ends_at']);
            $table->index(['source', 'status']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
