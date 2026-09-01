<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| فاکتور یک خرابی. subtotal از جمع ردیف‌های service_invoice_items میاد.
| commission_amount سهم پلتفرمه، technician_amount چیزیه که به کیف پول
| تکنسین واریز میشه (subtotal - commission_amount).
|
| فعلاً درگاه پرداخت آنلاین وصل نیست، پس paid_at فقط وقتی پر میشه که
| مشتری تحویل و رضایتش رو تایید کنه (رجوع کن به ServiceRequest::confirm).
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_invoices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('service_request_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('subtotal')->default(0);

            $table->unsignedTinyInteger('commission_percent')->default(15);

            $table->unsignedBigInteger('commission_amount')->default(0);

            $table->unsignedBigInteger('technician_amount')->default(0);

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

        });


        Schema::create('service_invoice_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('service_invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->unsignedBigInteger('amount');

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('service_invoice_items');
        Schema::dropIfExists('service_invoices');
    }
};
