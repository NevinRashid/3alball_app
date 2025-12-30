<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->boolean('enable_google')->default(false);
        });
    }

    public function down()
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn('enable_google');
        });
    }
};
