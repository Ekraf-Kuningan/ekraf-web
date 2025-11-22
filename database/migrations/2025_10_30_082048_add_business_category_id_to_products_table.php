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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'business_category_id')) {
                $table->unsignedBigInteger('business_category_id')->nullable()->after('sub_sektor_id');
            }
        });
        
        // Add foreign key separately to handle if it already exists
        try {
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('business_category_id')->references('id')->on('business_categories')->onDelete('set null');
            });
        } catch (\Exception $e) {
            // Foreign key already exists, skip
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'business_category_id')) {
                $table->dropForeign(['business_category_id']);
                $table->dropColumn('business_category_id');
            }
        });
    }
};
