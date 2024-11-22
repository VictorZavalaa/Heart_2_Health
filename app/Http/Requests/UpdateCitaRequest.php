<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitaRequest extends FormRequest
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
            'FechaYHoraInicioCita' => 'nullable|date_format:Y-m-d H:i:s',
            'FechaYHoraFinCita' => 'nullable|date_format:Y-m-d H:i:s',
            'MotivoCita' => 'nullable|string|max:255',
            'EstadoCita' => 'required|string|max:255',
            'idPaciente' => 'nullable|integer',
            'idDoctor' => 'nullable|integer',
        ];
    }
    
}
