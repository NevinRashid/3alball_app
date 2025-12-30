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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('buyer_name')->nullable(); // optional login
            $table->string('buyer_phone')->nullable();
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->text('recipient_address');
            $table->date('delivery_date')->nullable();
            $table->string('delivery_time')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'waiting_approval', 'approved', 'dispatched', 'delivered'])->default('pending');
            $table->timestamps();
    
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
