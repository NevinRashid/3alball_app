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
            $table->string('mid')->nullable();
            $table->string('tid')->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('enable_3d')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn(['mid', 'tid', 'ip_address', 'enable_3d']);
        });
    }
    
};
