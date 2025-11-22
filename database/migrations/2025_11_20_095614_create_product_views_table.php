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
        Schema::create('product_views', function (Blueprint $table) {
            $table->id();
            $table->string('product_id',20);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('ip_address',45);
            $table->string('user_agent',255)->nullable();
            $table->string('referrer',255)->nullable();
            $table->string('device_type',30)->nullable();
            $table->timestamp('viewed_at')->useCurrent();


            $table->index(['product_id','viewed_at']);
            $table->index('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_views');
    }
};
