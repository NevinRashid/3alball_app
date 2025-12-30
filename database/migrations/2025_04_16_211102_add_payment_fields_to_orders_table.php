<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable(); // 'cliq', 'apple_pay', 'credit_card'
            $table->string('payment_status')->default('pending'); // 'pending', 'approved', 'rejected'
            $table->string('payment_proof')->nullable(); // file path for bank transfer proof
            $table->decimal('admin_commission', 10, 2)->default(0);
            $table->decimal('store_earnings', 10, 2)->default(0);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'payment_proof', 'admin_commission', 'store_earnings']);
        });
        
    }
};
