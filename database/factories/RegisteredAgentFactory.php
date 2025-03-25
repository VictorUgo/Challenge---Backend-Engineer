<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegisteredAgent>
 */
class RegisteredAgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'state' => strtoupper($this->faker->stateAbbr),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'capacity' => $this->faker->numberBetween(5, 15),
        ];

    }
}
