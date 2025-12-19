<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\SubSektor;
use App\Models\BusinessCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(10000, 1000000),
            'stock' => fake()->numberBetween(0, 100),
            'image' => 'products/' . fake()->uuid() . '.jpg',
            'uploaded_at' => now(),
            'user_id' => User::factory(),
            'sub_sektor_id' => SubSektor::factory(),
            'business_category_id' => BusinessCategory::factory(),
            'status' => 'pending',
        ];
    }

    /**
     * Status: Pending (Menunggu Verifikasi)
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Status: Approved (Disetujui)
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Status: Rejected (Ditolak)
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }

    /**
     * Status: Inactive (Tidak Aktif)
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
