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
        Schema::table('users', function (Blueprint $table) {
            // Add level_id for user role (superadmin=1, admin=2, mitra=3)
            $table->unsignedBigInteger('level_id')->default(3)->after('phone_number');
        });

        // Copy level_id from mitras to users for existing records
        DB::statement('
            UPDATE users u
            INNER JOIN mitras m ON u.id = m.user_id
            SET u.level_id = COALESCE(m.level_id, 3)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('level_id');
        });
    }
};
