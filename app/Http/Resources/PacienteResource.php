<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
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
            'NomPac' => $this->NomPac,
            'ApePatPac' => $this->ApePatPac,
            'ApeMatPac' => $this->ApeMatPac,
            'FechNacPac' => $this->FechNacPac,
            'GenPac' => $this->GenPac,
            'DirPac' => $this->DirPac,
            'TelPac' => $this->TelPac,
            'FechPac' => $this->FechPac,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
