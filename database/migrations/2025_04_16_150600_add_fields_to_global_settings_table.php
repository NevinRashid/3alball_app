<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->string('default_language')->nullable()->after('theme_color');
            $table->string('footer_text')->nullable()->after('default_language');
            $table->string('copyright')->nullable()->after('footer_text');

            $table->string('site_logo')->nullable()->after('copyright');
            $table->string('site_favicon')->nullable()->after('site_logo');

            $table->boolean('enable_wallet')->default(false)->after('enable_campaigns');
            $table->boolean('maintenance_mode')->default(false)->after('enable_wallet');
        });
    }

    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn([
                'default_language',
                'footer_text',
                'copyright',
                'site_logo',
                'site_favicon',
                'enable_wallet',
                'maintenance_mode',
            ]);
        });
    }
};
