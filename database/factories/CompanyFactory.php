<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  // Crea un usuario si no se pasa uno
            'name' => $this->faker->company,
            'state' => strtoupper($this->faker->stateAbbr),
            'registered_agent_type' => 'user',
            'registered_agent_id' => null, // Lo puedes asignar en el test o usar el mismo user_id
        ];

    }
}
