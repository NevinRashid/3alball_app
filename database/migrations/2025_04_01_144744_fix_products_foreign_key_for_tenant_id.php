<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixProductsForeignKeyForTenantId extends Migration
{
    public function up()
    {
        // Only run this fix on databases that support it
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('products', function (Blueprint $table) {
                // Drop and re-add if needed
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            });

            Schema::table('products', function (Blueprint $table) {
                $table->uuid('tenant_id')->after('id');
                $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }
    }
}
