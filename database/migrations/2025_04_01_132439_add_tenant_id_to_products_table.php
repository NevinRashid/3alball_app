<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenantIdToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'tenant_id')) {
                $table->string('tenant_id')->after('id')->nullable();
                $table->index('tenant_id');
            }
        });

        // Add foreign key constraint only if DB supports it
        if (Schema::hasTable('tenants') && env('DB_CONNECTION') !== 'sqlite') {
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('tenant_id')
                      ->references('id')
                      ->on('tenants')
                      ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // Skip dropping column and foreign key if using SQLite
        if (env('DB_CONNECTION') !== 'sqlite') {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }
    }
}
