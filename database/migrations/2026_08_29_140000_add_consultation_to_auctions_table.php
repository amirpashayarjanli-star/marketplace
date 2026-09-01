<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
| مشاوره‌ی پیش از انتشار — کارفرما پیش از رفتن پروژه‌اش به فهرست مزایده‌ها
| باید با ما تماس بگیرد و مشاوره بگیرد. مدیر پس از مشاوره آن را ثبت و
| مزایده را منتشر می‌کند. اگر consultation_fee تنظیم شده باشد، انتشار
| مشروط به پرداخت آن است.
*/

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {

            // ثبت مشاوره توسط مدیر
            $table->timestamp('consulted_at')->nullable()->after('status');
            $table->text('consultation_note')->nullable()->after('consulted_at');
            $table->foreignId('consulted_by')->nullable()->after('consultation_note')
                ->constrained('users')->nullOnDelete();

            // درخواست تماس از سمت کارفرما
            $table->timestamp('callback_requested_at')->nullable()->after('consulted_by');

            // هزینه‌ی مشاوره (تومان) کش‌شده از config، و زمان پرداختش
            $table->unsignedBigInteger('consultation_fee')->default(0)->after('callback_requested_at');
            $table->timestamp('consultation_paid_at')->nullable()->after('consultation_fee');
        });

        /*
        | مناقصه‌های ستادِ موجود کارفرمای داخلی ندارند و نباید پشت این گیت
        | بمانند — «مشاوره‌شده» علامتشان می‌زنیم.
        */
        Schema::getConnection()->table('auctions')
            ->where('source', 'external')
            ->update(['consulted_at' => now()]);
    }


    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('consulted_by');
            $table->dropColumn([
                'consulted_at',
                'consultation_note',
                'callback_requested_at',
                'consultation_fee',
                'consultation_paid_at',
            ]);
        });
    }
};
