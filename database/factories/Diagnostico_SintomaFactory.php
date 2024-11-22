<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnostico_Sintoma>
 */
class Diagnostico_SintomaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idPaciente' => $this->faker->bigint(),
            'idSintoma' => $this->faker->bigint(),
        ];
    }
}
