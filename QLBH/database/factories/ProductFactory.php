<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_code' => fake()->unique()->bothify('SP###'),
            'product_name' => fake()->words(3, true),
            'price' => fake()->numberBetween(100000, 500000),
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'state' => 'active',
            'quantity' => fake()->numberBetween(1, 100),
            'details' => fake()->sentence(),
            'image' => null,
        ];
    }
}