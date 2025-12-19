<?php

namespace Database\Factories;

use App\Models\BusinessCategory;
use App\Models\SubSektor;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessCategoryFactory extends Factory
{
    protected $model = BusinessCategory::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'sub_sector_id' => SubSektor::factory(),
        ];
    }
}
