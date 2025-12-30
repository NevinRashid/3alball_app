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
        Schema::create('global_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('support_email')->nullable();
            $table->json('delivery_days')->nullable(); // e.g., ["Monday", "Tuesday"]
            $table->json('delivery_times')->nullable(); // e.g., ["10:00-12:00", "14:00-16:00"]
            $table->string('theme_color')->nullable(); // e.g., "#ff3366"
            $table->boolean('enable_reviews')->default(true);
            $table->boolean('enable_campaigns')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_settings');
    }
};
