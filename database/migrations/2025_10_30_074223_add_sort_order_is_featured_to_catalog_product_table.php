<?php
// filepath: database/migrations/xxxx_xx_xx_xxxxxx_add_sort_order_is_featured_to_catalog_product_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            if (!Schema::hasColumn('catalog_product', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('catalog_id');
            }
            if (!Schema::hasColumn('catalog_product', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('sort_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->dropColumn(['sort_order', 'is_featured']);
        });
    }
};