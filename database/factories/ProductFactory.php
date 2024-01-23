<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id'     => \App\Models\ProductCategory::factory(),
            'name'            => $this->faker->unique()->word(),
            'description'     => $this->faker->text(255),
            'unit_of_measure' => $this->faker->randomElement(['kg', 'l', 'm', 'm2', 'm3', 'szt']),
            'sku'             => $this->faker->unique()->numberBetween(1000000000000, 9999999999999),
        ];
    }
}
