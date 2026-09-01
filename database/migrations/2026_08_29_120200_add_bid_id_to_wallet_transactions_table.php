<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {

            $table->foreignId('bid_id')
                ->nullable()
                ->after('service_request_id')
                ->constrained('bids')
                ->nullOnDelete();
        });
    }


    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('bid_id');
        });
    }
};
