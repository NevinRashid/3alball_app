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
    Schema::table('live_chats', function (Blueprint $table) {
        if (!Schema::hasColumn('live_chats', 'user_id')) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        }

        if (!Schema::hasColumn('live_chats', 'message')) {
            $table->text('message')->nullable();
        }

        if (!Schema::hasColumn('live_chats', 'file')) {
            $table->string('file')->nullable();
        }
    });
}


public function down()
{
    Schema::table('live_chats', function (Blueprint $table) {
        $table->dropColumn(['user_id', 'message', 'file']);
    });
}

};
