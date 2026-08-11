<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('employers', function (Blueprint $table) {

            $table->string('name')->after('user_id');

            $table->string('slug')->unique()->after('name');

            $table->string('mobile', 20)->nullable()->after('slug');

            $table->string('phone', 30)->nullable()->after('mobile');

            $table->string('email')->nullable()->after('phone');

            $table->string('province')->nullable()->after('email');

            $table->string('city')->nullable()->after('province');

            $table->text('address')->nullable()->after('city');

            $table->text('description')->nullable()->after('address');

            $table->boolean('is_verified')->default(false)->after('description');

            $table->boolean('is_active')->default(true)->after('is_verified');

        });
    }



    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {

            $table->dropColumn([
                'name',
                'slug',
                'mobile',
                'phone',
                'email',
                'province',
                'city',
                'address',
                'description',
                'is_verified',
                'is_active',
            ]);

        });
    }

};
