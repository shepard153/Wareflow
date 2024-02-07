<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_id'      => \App\Models\Contact::factory(),
            'warehouse_id'    => \App\Models\Warehouse::factory(),
            'description'     => $this->faker->sentence(),
            'tracking_number' => $this->faker->randomLetter() . $this->faker->randomNumber(7),
            'shipment_type'   => $this->faker->randomElement(['incoming', 'outgoing', 'warehouse_transfer']),
            'status'          => $this->faker->randomElement(['created', 'pending', 'on_hold', 'in_transit', 'delivered', 'canceled']),
            'scheduled_date'  => $this->faker->dateTimeBetween('-1 week', '+3 weeks'),
            'shipment_date'   => function (array $attributes): ?\DateTime {
                return $attributes['status'] === 'delivered'
                    ? $this->faker->dateTimeBetween($attributes['scheduled_date'], $attributes['scheduled_date']->format('Y-m-d H:i:s') . ' +3 days')
                    : null;
            },
        ];
    }
}
