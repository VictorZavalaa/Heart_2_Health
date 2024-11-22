<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seguimiento>
 */
class SeguimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'FechSeguimiento' => $this->faker->date(),
            'DetalleSeg' => $this->faker->text(),
            'Glucosa' => $this->faker->double(),
            'Ritmo_Cardiaco' => $this->faker->double(),
            'Presion' => $this->faker->text(),
            'idCita' => $this->faker->bigint(),
        ];
    }
}
