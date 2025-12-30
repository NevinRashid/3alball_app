<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChatSessionIdToLiveChatsTable extends Migration
{
    public function up()
    {
        Schema::table('live_chats', function (Blueprint $table) {
            $table->string('chat_session_id')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('live_chats', function (Blueprint $table) {
            $table->dropColumn('chat_session_id');
        });
    }
}
