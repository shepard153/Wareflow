<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => $this->faker->name,
            'address'      => $this->faker->address,
            'phone'        => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
            'contact_type' => $this->faker->randomElement(['sender', 'recipient', 'carrier']),
        ];
    }
}
