<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::table('users', function (Blueprint $table) {
            // Change gender column to allow longer strings and make nullable
            $table->string('gender', 20)->nullable()->change();
        });
        
        if (Schema::hasTable('temporary_users')) {
            Schema::table('temporary_users', function (Blueprint $table) {
                // Change gender column to allow longer strings and make nullable
                $table->string('gender', 20)->nullable()->change();
            });
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::table('users', function (Blueprint $table) {
            // Revert gender column to original size
            $table->string('gender', 1)->change();
        });
        
        if (Schema::hasTable('temporary_users')) {
            Schema::table('temporary_users', function (Blueprint $table) {
                // Revert gender column to original size
                $table->string('gender', 1)->change();
            });
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
