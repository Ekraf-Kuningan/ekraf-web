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
            $table->text('rejection_reason')->nullable()->after('status');
            $table->timestamp('verified_at')->nullable()->after('rejection_reason');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            
            // Add foreign key untuk verified_by (admin yang melakukan verifikasi)
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['rejection_reason', 'verified_at', 'verified_by']);
        });
    }
};
