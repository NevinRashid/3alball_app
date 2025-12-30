<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEndedAtToLiveChatsTable extends Migration
{
    public function up()
    {
        Schema::table('live_chats', function (Blueprint $table) {
            $table->timestamp('ended_at')->nullable()->after('created_at');
        });
    }

    public function down()
    {
        Schema::table('live_chats', function (Blueprint $table) {
            $table->dropColumn('ended_at');
        });
    }
}
