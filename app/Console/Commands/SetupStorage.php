<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup storage directories and symlink for new environment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up storage directories...');
        
        // Buat direktori yang diperlukan
        $directories = [
            storage_path('app/public'),
            storage_path('app/public/avatars'),
            storage_path('app/public/articles'),
            storage_path('app/public/banners'),
            storage_path('app/public/catalogs'),
        ];
        
        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("Created directory: {$directory}");
            } else {
                $this->line("Directory already exists: {$directory}");
            }
        }
        
        // Buat symlink storage
        $this->info('Creating storage link...');
        $this->call('storage:link');
        
        // Copy default images jika tidak ada
        $this->info('Setting up default images...');
        $defaultImages = [
            'User.png' => storage_path('app/public/default-avatar.png'),
        ];
        
        foreach ($defaultImages as $source => $destination) {
            $sourcePath = public_path('assets/img/' . $source);
            if (File::exists($sourcePath) && !File::exists($destination)) {
                File::copy($sourcePath, $destination);
                $this->info("Copied default image: {$source}");
            }
        }
        
        $this->info('Storage setup completed!');
        
        return Command::SUCCESS;
    }
}
