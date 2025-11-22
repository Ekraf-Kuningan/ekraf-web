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
            $table->string('nik', 16)->nullable()->after('phone_number');
            $table->string('nib', 13)->nullable()->after('nik');
            $table->text('alamat')->nullable()->after('nib');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'nib', 'alamat']);
        });
    }
};
