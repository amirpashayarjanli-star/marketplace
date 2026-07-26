<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('technicians', function (Blueprint $table) {


            $table->id();



            $table->string('name');


            $table->string('slug')->unique();




            $table->string('avatar')->nullable();



            $table->string('mobile', 20)->nullable();


            $table->string('phone', 30)->nullable();




            $table->string('province')->nullable();


            $table->string('city')->nullable();



            $table->text('address')->nullable();




            $table->text('description')->nullable();




            // تخصص و سابقه

            $table->integer('experience')
                ->default(0);



            $table->integer('projects_count')
                ->default(0);



            $table->integer('repairs_count')
                ->default(0);




            // امتیاز

            $table->decimal('rating', 2, 1)
                ->default(0);



            $table->integer('reviews_count')
                ->default(0);





            // وضعیت تایید

            $table->boolean('is_verified')
                ->default(false);



            $table->boolean('is_active')
                ->default(true);



            $table->timestamps();


        });
    }



    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }

};
