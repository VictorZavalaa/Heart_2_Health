<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCitaRequest extends FormRequest
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
            'FechaYHoraInicioCita' => 'required|date_format:Y-m-d H:i:s',
            'FechaYHoraFinCita' => 'required|date_format:Y-m-d H:i:s',
            'MotivoCita' => 'required|string|max:255',
            'EstadoCita' => 'required|string|max:255',
            'idPaciente' => 'required|integer',
            'idDoctor' => 'integer',
        ];
    }
}
