<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrador>
 */
class AdministradorFactory extends Factory
{

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'NomAdmin' => $this->faker->name(),
            'ApePatAdmin' => $this->faker->lastName(),
            'ApeMatAdmin' => $this->faker->lastName(),
            'FechaNacAdmin' => $this->faker->date(),
            'TelAdmin' => $this->faker->phoneNumber(),
            'FechAdmin' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'admin',
        ];
    }
}
