<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Drop foreign key from online_store_links (if exists)
        try {
            Schema::table('online_store_links', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
            });
        } catch (\Exception $e) {
            // FK already dropped or doesn't exist
        }

        // Step 2: Add temporary id_produk column to products
        Schema::table('products', function (Blueprint $table) {
            $table->string('id_produk', 20)->nullable()->after('id');
        });

        // Step 3: Generate custom IDs for existing products
        $products = DB::table('products')
            ->join('sub_sectors', 'products.sub_sektor_id', '=', 'sub_sectors.id')
            ->select('products.id', 'sub_sectors.title')
            ->orderBy('products.id')
            ->get();

        $subSectorCounts = [];
        foreach ($products as $product) {
            $firstLetter = strtoupper(substr($product->title, 0, 1));
            if (!isset($subSectorCounts[$firstLetter])) {
                $subSectorCounts[$firstLetter] = 0;
            }
            $subSectorCounts[$firstLetter]++;
            $customId = 'PE' . $firstLetter . str_pad($subSectorCounts[$firstLetter], 3, '0', STR_PAD_LEFT);
            
            DB::table('products')->where('id', $product->id)->update(['id_produk' => $customId]);
        }

        // Step 4: Add temporary product_id_temp column to online_store_links
        Schema::table('online_store_links', function (Blueprint $table) {
            $table->string('product_id_temp', 20)->nullable()->after('product_id');
        });

        // Step 5: Migrate data from product_id to product_id_temp in online_store_links
        DB::statement('
            UPDATE online_store_links osl
            INNER JOIN products p ON osl.product_id = p.id
            SET osl.product_id_temp = p.id_produk
        ');

        // Step 6: Drop old product_id column from online_store_links
        Schema::table('online_store_links', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });

        // Step 7: Rename product_id_temp to product_id in online_store_links
        Schema::table('online_store_links', function (Blueprint $table) {
            $table->renameColumn('product_id_temp', 'product_id');
        });

        // Step 8: Add temporary product_id_temp column to catalog_product
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->string('product_id_temp', 20)->nullable()->after('product_id');
        });

        // Step 9: Migrate data from product_id to product_id_temp in catalog_product
        DB::statement('
            UPDATE catalog_product cp
            INNER JOIN products p ON cp.product_id = p.id
            SET cp.product_id_temp = p.id_produk
        ');

        // Step 10: Drop unique constraint before dropping product_id column
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->dropUnique(['catalog_id', 'product_id']);
        });

        // Step 11: Drop old product_id column from catalog_product
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });

        // Step 12: Rename product_id_temp to product_id in catalog_product
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->renameColumn('product_id_temp', 'product_id');
        });

        // Step 13: Re-establish unique constraint with new string product_id
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->unique(['catalog_id', 'product_id']);
        });

        // Step 14: Drop old id column and rename id_produk to id
        Schema::table('products', function (Blueprint $table) {
            $table->dropPrimary(['id']);
            $table->dropColumn('id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('id_produk', 'id');
        });

        // Step 15: Make id primary key
        Schema::table('products', function (Blueprint $table) {
            $table->primary('id');
        });

        // Step 17: Change product_id to string type in online_store_links (doctrine/dbal)
        Schema::table('online_store_links', function (Blueprint $table) {
            $table->string('product_id', 20)->change();
        });

        // Step 18: Re-establish foreign key in online_store_links
        Schema::table('online_store_links', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Rollback tidak didukung karena kompleksitas
        // Data ID yang sudah berubah tidak bisa dikembalikan dengan sempurna
        throw new \Exception('Migration rollback not supported - data has been permanently transformed');
    }
};
