<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeguimientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'FechSeg' => 'required|date',
            'DetalleSeg' => 'required|string|max:255',
            'Glucosa' => 'required|numeric',
            'Ritmo_Cardiaco' => 'required|numeric',
            'Presion' => 'required|string|max:255',
            'idCita' => 'integer',
        ];
    }
}
