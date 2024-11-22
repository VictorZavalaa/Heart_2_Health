<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recomendacion>
 */
class RecomendacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'DesRec' => $this->faker->text(),
            'FechRec ' => $this->faker->date(),
            'idCita' => $this->faker->bigint(),
        ];
    }
}
