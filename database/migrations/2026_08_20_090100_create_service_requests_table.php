<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| هسته‌ی پروسرویس: یک «خرابی» که مشتری ثبت می‌کنه.
|
| status:
|   reported     مشتری ثبت کرد، منتظر فاکتور از ادمین
|   invoiced     ادمین فاکتور زد، منتظر انتخاب تکنسین
|   assigned     تکنسین مشخص شد (اختصاصی یا انتخابی)، منتظر پذیرش تکنسین
|   accepted     تکنسین پذیرفت
|   on_the_way   تکنسین در راهه
|   arrived      تکنسین رسید
|   in_progress  در حال تعمیر
|   completed    تکنسین اعلام کرد کار تمومه، منتظر تایید مشتری
|   confirmed    مشتری تحویل و رضایت رو تایید کرد → پول به کیف پول تکنسین
|   cancelled    لغو شد
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {

            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('technicians')
                ->nullOnDelete();

            $table->string('status')->default('reported');

            $table->text('description');

            $table->text('address')->nullable();

            $table->boolean('has_insurance')->default(false);

            $table->unsignedTinyInteger('customer_rating')->nullable();

            $table->text('customer_feedback')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamp('confirmed_at')->nullable();

            $table->timestamps();

        });


        Schema::create('service_request_status_logs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('service_request_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status');

            $table->string('note')->nullable();

            $table->timestamp('created_at')->nullable();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('service_request_status_logs');
        Schema::dropIfExists('service_requests');
    }
};
