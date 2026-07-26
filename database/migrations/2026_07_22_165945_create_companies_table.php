<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {


            $table->id();



            $table->string('name');

            $table->string('slug')->unique();



            $table->string('manager_name')->nullable();



            $table->string('mobile', 20)->nullable();

            $table->string('phone', 30)->nullable();



            $table->string('email')->nullable();

            $table->string('website')->nullable();




            $table->string('province')->nullable();

            $table->string('city')->nullable();



            $table->text('address')->nullable();




            $table->string('logo')->nullable();

            $table->string('cover')->nullable();



            $table->text('description')->nullable();




            // اطلاعات اعتبار

            $table->decimal('rating', 2, 1)
                ->default(0);


            $table->integer('reviews_count')
                ->default(0);


            $table->integer('experience')
                ->default(0);


            $table->integer('projects_count')
                ->default(0);




            // وضعیت

            $table->boolean('is_verified')
                ->default(false);



            $table->boolean('is_active')
                ->default(true);



            $table->timestamps();


        });
    }



    public function down(): void
    {
        Schema::dropIfExists('companies');
    }

};
