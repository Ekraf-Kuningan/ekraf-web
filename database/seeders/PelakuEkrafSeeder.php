<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PelakuEkraf;
use App\Models\Level;
use App\Models\BusinessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelakuEkrafSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get default level (admin/superadmin level)
        $defaultLevel = Level::first();
        
        // Get default business category
        $defaultCategory = BusinessCategory::first();
        
        if (!$defaultLevel) {
            $this->command->error('No levels found. Please run LevelSeeder first.');
            return;
        }

        // Create pelaku ekraf for all users that don't have one
        User::doesntHave('pelakuEkraf')->chunk(100, function ($users) use ($defaultLevel, $defaultCategory) {
            foreach ($users as $user) {
                PelakuEkraf::create([
                    'user_id' => $user->id,
                    'business_name' => $user->name . ' Business', // Default business name
                    'business_status' => 'existing',
                    'level_id' => $defaultLevel->id,
                    'business_category_id' => $defaultCategory?->id,
                    'description' => 'Auto-generated pelaku ekraf record for existing user',
                ]);
                
                $this->command->info("Created pelaku ekraf for user: {$user->name}");
            }
        });
        
        $this->command->info('Pelaku Ekraf seeder completed!');
    }
}

