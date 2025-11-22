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
        Schema::table('users', function (Blueprint $table) {
            // Drop business-related columns as they are now in mitras table
            if (Schema::hasColumn('users', 'business_name')) {
                $table->dropColumn('business_name');
            }
            if (Schema::hasColumn('users', 'business_status')) {
                $table->dropColumn('business_status');
            }
            if (Schema::hasColumn('users', 'level_id')) {
                $table->dropColumn('level_id');
            }
            if (Schema::hasColumn('users', 'business_category_id')) {
                $table->dropColumn('business_category_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore business columns if migration is rolled back
            $table->string('business_name')->nullable();
            $table->string('business_status')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedInteger('business_category_id')->nullable();
        });
    }
};
