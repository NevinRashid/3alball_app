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
    Schema::table('coupons', function (Blueprint $table) {
        if (!Schema::hasColumn('coupons', 'code')) {
            $table->string('code')->unique()->after('id');
        }

        if (!Schema::hasColumn('coupons', 'discount')) {
            $table->decimal('discount', 5, 2)->default(0)->after('code');
        }

        if (!Schema::hasColumn('coupons', 'is_active')) {
            $table->boolean('is_active')->default(true)->after('expires_at');
        }
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
