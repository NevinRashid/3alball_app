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
            $table->string('google_merchant_id')->nullable();
            $table->text('google_note')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn(['google_merchant_id', 'google_note']);
        });
    }
    
};
