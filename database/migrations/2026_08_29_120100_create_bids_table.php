<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('bids', function (Blueprint $table) {

            $table->id();

            $table->foreignId('auction_id')
                ->constrained('auctions')
                ->cascadeOnDelete();

            // پیشنهاددهنده — کاربر با نقش شرکت/تولیدکننده/تکنسین
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // مبلغ پیشنهادی (تومان) و زمان تحویل (روز)
            $table->unsignedBigInteger('amount');
            $table->unsignedSmallInteger('delivery_days')->nullable();

            $table->text('description')->nullable();
            $table->string('attachment')->nullable();

            // active → won / lost / withdrawn
            $table->string('status')->default('active');

            // تراکنش کارمزدی که هنگام ثبت این پیشنهاد کسر شد
            $table->foreignId('fee_transaction_id')
                ->nullable()
                ->constrained('wallet_transactions')
                ->nullOnDelete();

            $table->timestamps();

            // هر کاربر فقط یک پیشنهاد فعال در هر مزایده
            $table->unique(['auction_id', 'user_id']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
