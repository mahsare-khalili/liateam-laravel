<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_price' =>fake()->numberBetween($min = 1500, $max = 6000),
            'count' => fake()->numberBetween($min = 1, $max = 60),
            'products' => Product::factory()->create()
        ];
    }
}
