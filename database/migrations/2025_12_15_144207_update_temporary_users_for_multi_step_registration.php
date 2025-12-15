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
            // Add columns for multi-step registration tracking
            $table->boolean('is_verified')->default(false)->after('verificationTokenExpiry');
            $table->boolean('profile_completed')->default(false)->after('is_verified');
            
            // Make profile fields nullable since they will be filled in step 3
            $table->string('name')->nullable()->change();
            $table->string('phone_number', 20)->nullable()->change();
            $table->string('nik', 16)->nullable()->change();
            $table->string('nib', 13)->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->enum('gender', ['male', 'female'])->nullable()->change();
            $table->string('image')->nullable()->change();
            $table->string('business_name')->nullable()->change();
            $table->enum('business_status', ['BARU', 'SUDAH_LAMA'])->nullable()->change();
            $table->unsignedBigInteger('sub_sektor_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_users', function (Blueprint $table) {
            $table->dropColumn(['is_verified', 'profile_completed']);
            
            // Revert to non-nullable (if needed)
            // Note: This might fail if there's existing null data
            $table->string('name')->nullable(false)->change();
            $table->string('phone_number', 20)->nullable(false)->change();
            $table->string('nik', 16)->nullable(false)->change();
            $table->string('nib', 13)->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
            $table->enum('gender', ['male', 'female'])->nullable(false)->change();
            $table->string('business_name')->nullable(false)->change();
            $table->enum('business_status', ['BARU', 'SUDAH_LAMA'])->nullable(false)->change();
            $table->unsignedBigInteger('sub_sektor_id')->nullable(false)->change();
        });
    }
};
