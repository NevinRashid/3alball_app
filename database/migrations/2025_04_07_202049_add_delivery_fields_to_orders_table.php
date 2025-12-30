<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'delivery_date')) {
                $table->string('delivery_date')->nullable();
            }

            if (!Schema::hasColumn('orders', 'delivery_time')) {
                $table->string('delivery_time')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Only try to drop columns if not SQLite
        if (env('DB_CONNECTION') !== 'sqlite') {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn(['delivery_date', 'delivery_time']);
            });
        }
    }
};
