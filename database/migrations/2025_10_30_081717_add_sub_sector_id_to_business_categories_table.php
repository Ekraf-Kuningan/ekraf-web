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
        Schema::table('business_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('business_categories', 'sub_sector_id')) {
                $table->unsignedBigInteger('sub_sector_id')->nullable()->after('id');
                $table->foreign('sub_sector_id')->references('id')->on('sub_sectors')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_categories', function (Blueprint $table) {
            if (Schema::hasColumn('business_categories', 'sub_sector_id')) {
                $table->dropForeign(['sub_sector_id']);
                $table->dropColumn('sub_sector_id');
            }
        });
    }
};
