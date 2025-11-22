<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('temporary_users', function (Blueprint $table) {
            // Drop business_category_id jika ada
            if (Schema::hasColumn('temporary_users', 'business_category_id')) {
                $table->dropColumn('business_category_id');
            }
            
            // Add sub_sektor_id jika belum ada
            if (!Schema::hasColumn('temporary_users', 'sub_sektor_id')) {
                $table->foreignId('sub_sektor_id')->nullable()->after('business_status')->constrained('sub_sectors')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('temporary_users', function (Blueprint $table) {
            if (Schema::hasColumn('temporary_users', 'sub_sektor_id')) {
                $table->dropForeign(['sub_sektor_id']);
                $table->dropColumn('sub_sektor_id');
            }
            
            if (!Schema::hasColumn('temporary_users', 'business_category_id')) {
                $table->integer('business_category_id')->nullable();
            }
        });
    }
};