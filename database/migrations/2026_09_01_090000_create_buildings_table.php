<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| «پرونده» — یک ساختمان متعلق به یک مشتری.
|
| قرارداد سرویس، بیمه‌نامه، تکنسین و تاریخچه‌ی خرابی‌ها همه به پرونده
| وصل می‌شوند نه مستقیم به مشتری، چون یک مدیر ساختمان یا انبوه‌ساز
| ممکن است چند ساختمان داشته باشد و هرکدام شرایط خودش را دارد.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            // شماره‌ی پرونده که به مشتری نشان داده می‌شود (AP-1404-0007)
            $table->string('code', 32)->unique();

            $table->string('title');

            $table->string('province')->nullable();

            $table->string('city')->nullable();

            $table->text('address');

            $table->string('postal_code', 20)->nullable();

            $table->unsignedSmallInteger('floors')->nullable();

            $table->unsignedSmallInteger('units')->nullable();

            // مدیر ساختمان، اگر خودِ ثبت‌کننده نیست
            $table->string('manager_name')->nullable();

            $table->string('manager_mobile', 20)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['customer_id', 'created_at']);

        });


        Schema::create('elevators', function (Blueprint $table) {

            $table->id();

            $table->foreignId('building_id')
                ->constrained()
                ->cascadeOnDelete();

            // «آسانسور شمالی»، «بلوک A» و ...
            $table->string('label');

            $table->string('brand')->nullable();

            $table->unsignedSmallInteger('capacity_kg')->nullable();

            $table->unsignedSmallInteger('stops')->nullable();

            $table->unsignedSmallInteger('install_year')->nullable();

            $table->string('serial_no')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('elevators');
        Schema::dropIfExists('buildings');
    }
};
