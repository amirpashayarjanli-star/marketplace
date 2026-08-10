<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_codes', function (Blueprint $table) {

            $table->id();

            // شماره موبایل
            $table->string('mobile')
                ->index();


            // کد 5 یا 6 رقمی
            $table->string('code');


            // نوع درخواست
            // login | register
            $table->enum('type', [

                'login',
                'register'

            ]);


            // زمان انقضا
            $table->timestamp('expires_at');


            // زمان تایید
            $table->timestamp('verified_at')
                ->nullable();


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
