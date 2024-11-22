<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'NomDoc' => $this->faker->name(),
            'ApePatDoc' => $this->faker->lastName(),
            'ApeMatDoc' => $this->faker->lastName(),
            'FechNacDoc' => $this->faker->date(),
            'GenDoc' => $this->faker->gender(),
            'DirDoc' => $this->faker->address(),
            'TelDoc' => $this->faker->phoneNumber(),
            'Especialidad' => $this->faker->jobTitle(),
            'FechDoc' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'doctor',

        ];
    }
}
