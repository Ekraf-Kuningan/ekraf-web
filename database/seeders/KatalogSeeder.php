<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Katalog;
use App\Models\SubSektor;
use App\Models\Product;
use Illuminate\Support\Str;

class KatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sub sectors
        $subSektors = SubSektor::all();

        if ($subSektors->isEmpty()) {
            $this->command->error('No sub sectors found. Please run SubSektorSeeder first.');
            return;
        }

        // Sample katalog data
        $katalogs = [
            [
                'title' => 'Katalog Produk Kuliner Kuningan',
                'slug' => 'katalog-produk-kuliner-kuningan',
                'description' => 'Kumpulan produk kuliner terbaik dari Kuningan, mulai dari makanan tradisional hingga modern.',
                'sub_sector_id' => $subSektors->where('title', 'Kuliner')->first()?->id ?? $subSektors->random()->id,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Katalog Kerajinan Tangan',
                'slug' => 'katalog-kerajinan-tangan',
                'description' => 'Berbagai kerajinan tangan unik dan berkualitas dari pengrajin lokal Kuningan.',
                'sub_sector_id' => $subSektors->where('title', 'Kriya')->first()?->id ?? $subSektors->random()->id,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Katalog Fashion & Aksesoris',
                'slug' => 'katalog-fashion-aksesoris',
                'description' => 'Koleksi fashion dan aksesoris terkini dari desainer lokal Kuningan.',
                'sub_sector_id' => $subSektors->where('title', 'Fashion')->first()?->id ?? $subSektors->random()->id,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Katalog Produk Digital',
                'slug' => 'katalog-produk-digital',
                'description' => 'Aplikasi dan game developer dari Kuningan. Inovasi digital terdepan.',
                'sub_sector_id' => $subSektors->where('title', 'Aplikasi dan Game Developer')->first()?->id ?? $subSektors->random()->id,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'title' => 'Katalog Desain & Kreatif',
                'slug' => 'katalog-desain-kreatif',
                'description' => 'Kumpulan karya desain grafis, desain interior, dan produk kreatif lainnya.',
                'sub_sector_id' => $subSektors->where('title', 'Desain Komunikasi Visual')->first()?->id ?? $subSektors->random()->id,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'title' => 'Katalog Seni & Budaya',
                'slug' => 'katalog-seni-budaya',
                'description' => 'Karya seni rupa, musik, dan seni pertunjukan dari seniman Kuningan.',
                'sub_sector_id' => $subSektors->where('title', 'Seni Rupa')->first()?->id ?? $subSektors->random()->id,
                'is_featured' => false,
                'status' => 'draft',
            ],
        ];

        foreach ($katalogs as $katalogData) {
            $katalog = Katalog::create($katalogData);

            $this->command->info("Created katalog: {$katalog->title}");

            // Attach products to katalog (if products exist)
            $products = Product::where('status', 'disetujui')
                ->where('sub_sektor_id', $katalog->sub_sector_id)
                ->take(5)
                ->get();

            if ($products->isNotEmpty()) {
                $sortOrder = 1;
                foreach ($products as $product) {
                    $katalog->products()->attach($product->id, [
                        'sort_order' => $sortOrder,
                        'is_featured' => $sortOrder <= 2, // First 2 products are featured
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $sortOrder++;
                }
                $this->command->info("  - Attached {$products->count()} products to {$katalog->title}");
            }
        }

        $this->command->info('Katalog seeder completed successfully!');
    }
}
