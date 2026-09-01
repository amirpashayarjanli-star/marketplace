<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
| پرداخت‌های شارژ کیف‌پول (زرین‌پال).
| جدا از wallet_transactions است چون یک پرداخت ممکن است ناموفق بماند و
| هرگز به تراکنش کیف‌پول تبدیل نشود؛ ولی باید ردش را داشته باشیم.
*/

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('wallet_payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // مبلغ به تومان
            $table->unsignedBigInteger('amount');

            $table->string('gateway')->default('zarinpal');

            // authority یکتاست تا callback تکراری نتواند دو بار شارژ کند
            $table->string('authority')->nullable()->unique();
            $table->string('ref_id')->nullable();
            $table->string('card_pan')->nullable();

            // pending → paid / failed / canceled
            $table->string('status')->default('pending');
            $table->string('message')->nullable();

            // تراکنش کیف‌پولی که پس از تایید ساخته شد
            $table->foreignId('wallet_transaction_id')
                ->nullable()
                ->constrained('wallet_transactions')
                ->nullOnDelete();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('wallet_payments');
    }
};
