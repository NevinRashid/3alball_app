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
        $table->boolean('enable_cliq')->default(false);
        $table->boolean('enable_credit')->default(false);
        $table->boolean('enable_apple')->default(false);
        $table->string('bank_name')->nullable();
        $table->string('iban')->nullable();
        $table->text('payment_note')->nullable();
        $table->string('cliq_name')->nullable();
        $table->string('cliq_alias')->nullable();
        $table->decimal('credit_fee', 5, 2)->nullable();
        $table->string('apple_note')->nullable();
        $table->string('apple_merchant_id')->nullable();
    });
}

public function down()
{
    Schema::table('global_settings', function (Blueprint $table) {
        $table->dropColumn([
            'enable_cliq', 'enable_credit', 'enable_apple',
            'bank_name', 'iban', 'payment_note',
            'cliq_name', 'cliq_alias',
            'credit_fee', 'apple_note', 'apple_merchant_id'
        ]);
    });
}

};
