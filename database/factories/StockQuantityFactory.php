<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockQuantity>
 */
class StockQuantityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id'   => \App\Models\Product::factory(),
            'location_id'  => \App\Models\ProductLocation::factory(),
            'quantity'     => $this->faker->numberBetween(0, 100),
        ];
    }
}
