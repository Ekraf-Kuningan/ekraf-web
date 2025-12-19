<?php

namespace Database\Factories;

use App\Models\SubSektor;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubSektorFactory extends Factory
{
    protected $model = SubSektor::class;

    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'Kerajinan',
                'Fashion',
                'Kuliner',
                'Musik',
                'Seni Rupa',
                'Desain',
                'Film',
                'Fotografi',
                'Arsitektur',
                'Teknologi'
            ]),
            'description' => fake()->sentence(),
            'icon' => 'icons/' . fake()->uuid() . '.svg',
        ];
    }
}
