<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| قرارداد سرویس روی یک پرونده.
|
| status:
|   draft             مشتری هنوز ثبت نکرده
|   pending_review    ثبت شد، منتظر بررسی و قیمت‌گذاری ادمین
|   awaiting_payment  ادمین قیمت گذاشت، منتظر پرداخت مشتری
|   active            پرداخت شد و در جریان است
|   expired           تاریخش گذشته
|   cancelled         لغو شده
|
| plan: periodic (سرویس دوره‌ای) | on_demand (سرویس موردی)
| term: monthly | quarterly | yearly
|
| مبلغ‌ها به تومان و در لحظه‌ی قیمت‌گذاری snapshot می‌شوند — قیمت‌های
| config بعداً عوض می‌شود و نباید روی قراردادهای بسته‌شده اثر بگذارد.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_contracts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('building_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('code', 32)->unique();

            $table->string('plan')->default('periodic');

            $table->string('term')->default('monthly');

            $table->string('status')->default('pending_review');

            // نحوه‌ی تعیین تکنسین + تکنسین ثابت در حالت dedicated
            $table->string('technician_mode')->default('assigned');

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('technicians')
                ->nullOnDelete();

            // snapshot قیمت در لحظه‌ی قیمت‌گذاری
            $table->unsignedSmallInteger('elevator_count')->default(1);

            $table->unsignedBigInteger('monthly_fee')->default(0);

            $table->unsignedSmallInteger('months')->default(1);

            $table->unsignedTinyInteger('discount_percent')->default(0);

            $table->unsignedBigInteger('total_amount')->default(0);

            $table->unsignedSmallInteger('visits_per_month')->default(0);

            $table->date('starts_at')->nullable();

            $table->date('ends_at')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamp('cancelled_at')->nullable();

            $table->string('cancel_reason')->nullable();

            $table->text('admin_note')->nullable();

            $table->timestamps();

            $table->index(['status', 'ends_at']);

        });


        /*
        | بیمه‌نامه‌ی واقعی صادرشده برای یک قرارداد. جدول جداست تا با
        | تمدید قرارداد، بیمه‌نامه‌های قبلی در تاریخچه بمانند.
        */
        Schema::create('insurance_policies', function (Blueprint $table) {

            $table->id();

            $table->foreignId('service_contract_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('insurer');

            $table->string('policy_no');

            $table->unsignedBigInteger('coverage_amount')->default(0);

            $table->date('starts_at');

            $table->date('ends_at');

            // اسکن بیمه‌نامه
            $table->string('document_path')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('ends_at');

        });


        /*
        | بازدیدهای دوره‌ای که از روی قرارداد periodic ساخته می‌شوند.
        |
        | status: due (موعدش رسیده) | done (انجام شد) | missed (از دست رفت)
        */
        Schema::create('maintenance_visits', function (Blueprint $table) {

            $table->id();

            $table->foreignId('service_contract_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('technicians')
                ->nullOnDelete();

            $table->date('due_on');

            $table->string('status')->default('due');

            $table->timestamp('done_at')->nullable();

            $table->text('report')->nullable();

            $table->unsignedTinyInteger('customer_rating')->nullable();

            $table->timestamps();

            $table->index(['status', 'due_on']);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('maintenance_visits');
        Schema::dropIfExists('insurance_policies');
        Schema::dropIfExists('service_contracts');
    }
};
