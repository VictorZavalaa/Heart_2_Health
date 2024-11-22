<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeguimientoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'FechSeg' => $this->FechSeg,
            'DetalleSeg' => $this->DetalleSeg,
            'Glucosa' => $this->Glucosa,
            'Ritmo_Cardiaco' => $this->Ritmo_Cardiaco,
            'Presion' => $this->Presion,
            'idCita' => $this->idCita,

        ];
    }
}
