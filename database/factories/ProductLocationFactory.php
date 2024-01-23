<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ProductLocation>
 */
class ProductLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warehouse_id' => \App\Models\Warehouse::factory(),
            'aisle'        => strtoupper($this->faker->randomLetter()),
            'shelf'        => $this->faker->randomLetter(),
            'bin'          => $this->faker->randomNumber(2),
        ];
    }
}
