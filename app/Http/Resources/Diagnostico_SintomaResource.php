<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Diagnostico_SintomaResource extends JsonResource
{
    public static $wrap = false; // Desactivamos el wrapping de datos

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'idPaciente' => $this->idPaciente,
            'idSintoma' => $this->idSintoma,
        ];
    }
}
