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
        Schema::table('stores', function (Blueprint $table) {
            if (!Schema::hasColumn('stores', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            if (!Schema::hasColumn('stores', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('stores', 'whatsapp')) {
                $table->string('whatsapp')->nullable();
            }
            if (!Schema::hasColumn('stores', 'theme')) {
                $table->string('theme')->default('auto');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['instagram', 'facebook', 'whatsapp', 'theme']);
        });
    }
};
