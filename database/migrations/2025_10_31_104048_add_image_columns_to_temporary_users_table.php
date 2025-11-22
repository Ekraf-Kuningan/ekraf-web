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
        Schema::table('temporary_users', function (Blueprint $table) {
            $table->string('image')->nullable()->after('phone_number');
            $table->string('cloudinary_id')->nullable()->after('image');
            $table->json('cloudinary_meta')->nullable()->after('cloudinary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_users', function (Blueprint $table) {
            $table->dropColumn(['image', 'cloudinary_id', 'cloudinary_meta']);
        });
    }
};
