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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('business_name')->nullable();
            $table->string('business_status')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('business_category_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // NOTE: foreign keys intentionally omitted here to avoid migration order/type
            // issues during the larger DB revamp. Add FKs in a dedicated migration
            // after the dependent tables are guaranteed to exist and have correct types.
        });

        // Copy existing business fields from users to mitras (if any)
        if (Schema::hasTable('users')) {
            DB::table('users')
                ->select('id as user_id', 'business_name', 'business_status', 'level_id', 'business_category_id')
                ->whereNotNull('business_name')
                ->orWhereNotNull('business_category_id')
                ->orWhereNotNull('level_id')
                ->orderBy('id')
                ->chunk(100, function ($rows) {
                    $insert = [];
                    foreach ($rows as $row) {
                        $insert[] = [
                            'user_id' => $row->user_id,
                            'business_name' => $row->business_name,
                            'business_status' => $row->business_status,
                            'level_id' => $row->level_id,
                            'business_category_id' => $row->business_category_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    if (!empty($insert)) {
                        DB::table('mitras')->insert($insert);
                    }
                });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
