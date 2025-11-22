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
            // Rename column from business_category_id to sub_sektor_id
            $table->renameColumn('business_category_id', 'sub_sektor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rename back from sub_sektor_id to business_category_id
            $table->renameColumn('sub_sektor_id', 'business_category_id');
        });
    }
};
