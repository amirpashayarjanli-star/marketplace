<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {


            $table->id();



            $table->string('title');


            $table->string('slug')->unique();



            $table->string('image')->nullable();



            $table->string('province')->nullable();


            $table->string('city')->nullable();




            $table->string('type')->nullable();




            $table->text('description')->nullable();




            // کارفرما

            $table->foreignId('employer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();




            // شرکت آسانسوری اجرا کننده

            $table->foreignId('company_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();




            // تکنسین

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();




            // تولیدکننده تجهیزات

            $table->foreignId('manufacturer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();




            $table->boolean('is_verified')
                ->default(false);



            $table->boolean('is_active')
                ->default(true);



            $table->timestamps();


        });
    }



    public function down(): void
    {
        Schema::dropIfExists('projects');
    }

};
