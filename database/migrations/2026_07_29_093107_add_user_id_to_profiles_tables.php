<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {


        Schema::table('companies', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

        });



        Schema::table('manufacturers', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

        });



        Schema::table('stores', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

        });



        Schema::table('technicians', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

        });



        Schema::table('employers', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

        });


    }





    public function down(): void
    {


        Schema::table('companies', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn('user_id');

        });



        Schema::table('manufacturers', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn('user_id');

        });



        Schema::table('stores', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn('user_id');

        });



        Schema::table('technicians', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn('user_id');

        });



        Schema::table('employers', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn('user_id');

        });


    }


};
