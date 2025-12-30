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
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('body');
        $table->string('type')->nullable(); // e.g. order, campaign, message
        $table->unsignedBigInteger('user_id')->nullable(); // target user
        $table->unsignedBigInteger('order_id')->nullable(); // optional: link to order
        $table->string('image')->nullable(); // optional image
        $table->timestamp('read_at')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
