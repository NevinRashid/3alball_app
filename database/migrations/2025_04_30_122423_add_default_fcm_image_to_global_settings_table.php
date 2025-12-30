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
    Schema::table('global_settings', function (Blueprint $table) {
        $table->string('default_fcm_image')->nullable()->after('site_logo');
    });
}

public function down()
{
    Schema::table('global_settings', function (Blueprint $table) {
        $table->dropColumn('default_fcm_image');
    });
}

};
