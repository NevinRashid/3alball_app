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
        if (!Schema::hasColumn('live_chats', 'from_admin')) {
            $table->boolean('from_admin')->default(false)->after('message');
        }
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_chats', function (Blueprint $table) {
            //
        });
    }
};
