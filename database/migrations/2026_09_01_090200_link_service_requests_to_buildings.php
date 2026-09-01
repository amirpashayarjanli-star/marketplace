<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| خرابی‌ها تا الان فقط به مشتری وصل بودند و آدرس را دستی می‌گرفتند.
| حالا هر خرابی زیر یک پرونده ثبت می‌شود تا تاریخچه‌ی ساختمان کامل
| باشد، و قرارداد فعالِ همان لحظه رویش snapshot می‌شود.
|
| covered_by_contract یعنی این خرابی داخل پوشش قرارداد دوره‌ای بود و
| نباید از مشتری پول گرفته شود.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {

            $table->foreignId('building_id')
                ->nullable()
                ->after('customer_id')
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('elevator_id')
                ->nullable()
                ->after('building_id')
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('service_contract_id')
                ->nullable()
                ->after('elevator_id')
                ->constrained()
                ->nullOnDelete();

            $table->boolean('covered_by_contract')
                ->default(false)
                ->after('has_insurance');

            $table->timestamp('cancelled_at')->nullable()->after('confirmed_at');

            $table->string('cancel_reason')->nullable()->after('cancelled_at');

        });
    }


    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {

            $table->dropConstrainedForeignId('building_id');
            $table->dropConstrainedForeignId('elevator_id');
            $table->dropConstrainedForeignId('service_contract_id');

            $table->dropColumn([
                'covered_by_contract',
                'cancelled_at',
                'cancel_reason',
            ]);

        });
    }
};
