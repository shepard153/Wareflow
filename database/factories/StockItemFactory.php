<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockQuantity>
 */
class StockItemFactory extends Factory
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
            'warehouse_id' => \App\Models\Warehouse::factory(),
            'shipment_id'  => \App\Models\Shipment::factory(),
            'product_variation_id' => \App\Models\ProductVariation::factory(),
            'quantity'     => $this->faker->numberBetween(0, 100),
            'batch_number' => $this->faker->randomNumber(5),
            'barcode'      => $this->faker->randomNumber(5),
            'expiry_date'  => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
