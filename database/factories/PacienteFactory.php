<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'NomPac' => $this->faker->name(),
            'ApePatPac' => $this->faker->lastName(),
            'ApeMatPac' => $this->faker->lastName(),
            'FechNacPac' => $this->faker->date(),
            'GenPac' => $this->faker->gender(),
            'DirPac' => $this->faker->address(),
            'TelPac' => $this->faker->phoneNumber(),
            'FechPac' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'paciente',

        ];
    }
}
