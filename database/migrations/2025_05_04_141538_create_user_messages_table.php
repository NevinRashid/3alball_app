<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->string('type')->default('system'); // e.g., order, support, promo
            $table->foreignId('related_order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->boolean('is_read')->default(false);
            $table->string('sent_by')->default('system'); // system, admin, support_agent
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_messages');
    }
}
