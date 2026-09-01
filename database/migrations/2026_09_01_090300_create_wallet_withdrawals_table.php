<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| درخواست برداشت از کیف‌پول.
|
| تا اینجا پول فقط وارد کیف‌پول می‌شد (تسویه‌ی خرابی، برگشت کارمزد
| مزایده) و هیچ راهی برای خروجش نبود؛ تکنسینی که کار کرده بود عملاً
| نمی‌توانست به پولش برسد.
|
| مبلغ در لحظه‌ی ثبت درخواست از کیف‌پول کسر می‌شود (نه موقع تایید)،
| وگرنه کاربر می‌توانست همان پول را همزمان جای دیگری خرج کند. اگر
| درخواست رد شود، مبلغ برمی‌گردد.
|
| status: pending → approved / rejected
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_withdrawals', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('amount');

            $table->string('iban', 34);

            $table->string('account_holder');

            $table->string('status')->default('pending');

            // شماره پیگیری واریز که ادمین بعد از انتقال وارد می‌کند
            $table->string('reference')->nullable();

            $table->string('admin_note')->nullable();

            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('wallet_withdrawals');
    }
};
