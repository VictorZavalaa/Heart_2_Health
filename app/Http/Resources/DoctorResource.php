<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'NomDoc' => $this->NomDoc,
            'ApePatDoc' => $this->ApePatDoc,
            'ApeMatDoc' => $this->ApeMatDoc,
            'FechNacDoc' => $this->FechNacDoc,
            'GenDoc' => $this->GenDoc,
            'DirDoc' => $this->DirDoc,
            'TelDoc' => $this->TelDoc,
            'Especialidad' => $this->Especialidad,
            'FechDoc' => $this->FechDoc,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
