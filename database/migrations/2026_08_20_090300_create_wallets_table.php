<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| کیف پول — فعلاً فقط برای تکنسین‌ها استفاده میشه (واریز سهم‌شون بعد از
| تایید مشتری). ساختارش عمومیه تا بعداً برای نقش‌های دیگه هم قابل استفاده باشه.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('balance')->default(0);

            $table->timestamps();

        });


        Schema::create('wallet_transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('wallet_id')
                ->constrained()
                ->cascadeOnDelete();

            // credit = واریز به کیف پول، debit = برداشت/کسر
            $table->string('type');

            $table->unsignedBigInteger('amount');

            $table->string('description')->nullable();

            $table->foreignId('service_request_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('wallets');
    }
};
