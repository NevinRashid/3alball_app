<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('banners', function (Blueprint $table) {
        $table->boolean('is_campaign')->default(false)->after('is_active');
    });
}

public function down()
{
    Schema::table('banners', function (Blueprint $table) {
        $table->dropColumn('is_campaign');
    });
}

};
