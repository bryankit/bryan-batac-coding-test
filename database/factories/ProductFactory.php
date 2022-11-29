<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_name' => 'product ' . fake()->userName,
            'product_description' => fake()->sentence(4, true),
            'product_price' => fake()->randomFloat(2,10,999),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
