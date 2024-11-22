<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'FechaYHoraInicioCita' => $this->faker->dateTime(),
            'FechaYHoraFinCita' => $this->faker->dateTime(),
            'MotivoCita' => $this->faker->text(),
            'EstadoCita' => $this->faker->text(),
            'idPaciente' => $this->faker->bigint(),
            'idDoctor' => $this->faker->bigint(),
        ];  
    }
}
