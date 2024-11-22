<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitaResource extends JsonResource
{

    public static $wrap = false; // Desactivamos el wrapping de datos

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'FechaYHoraInicioCita' => $this->FechaYHoraInicioCita,
            'FechaYHoraFinCita' => $this->FechaYHoraFinCita,
            'MotivoCita' => $this->MotivoCita,
            'EstadoCita' => $this->EstadoCita,
            'idPaciente' => $this->idPaciente,
            'idDoctor' => $this->idDoctor,
        ];
    }
}
