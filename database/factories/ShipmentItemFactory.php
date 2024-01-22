<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShipmentItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shipment_id'  => \App\Models\Shipment::factory(),
            'product_id'   => \App\Models\Product::factory(),
            'location_id'  => \App\Models\ProductLocation::factory(),
            'quantity'     => $this->faker->numberBetween(1, 100),
            'batch_number' => $this->faker->randomNumber(),
            'barcode'      => $this->faker->randomNumber(),
            'expiry_date'  => $this->faker->date(),
        ];
    }
}
