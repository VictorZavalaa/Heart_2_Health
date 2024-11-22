<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdministradorResource extends JsonResource
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
            'idAdmin' => $this->idAdmin,
            'NomAdmin' => $this->NomAdmin,
            'ApePatAdmin' => $this->ApePatAdmin,
            'ApeMatAdmin' => $this->ApeMatAdmin,
            'FechaNacAdmin' => $this->FechaNacAdmin,
            'TelAdmin' => $this->TelAdmin,
            'FechAdmin' => $this->FechAdmin,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
