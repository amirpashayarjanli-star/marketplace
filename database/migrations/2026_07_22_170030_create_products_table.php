<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {


            $table->id();



            $table->string('name');


            $table->string('slug')->unique();



            $table->string('image')->nullable();



            $table->string('category')->nullable();



            $table->text('description')->nullable();




            // برند

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();




            // تولیدکننده

            $table->foreignId('manufacturer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();




            // فروشگاه تامین کننده

            $table->foreignId('store_id')
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
        Schema::dropIfExists('products');
    }

};
