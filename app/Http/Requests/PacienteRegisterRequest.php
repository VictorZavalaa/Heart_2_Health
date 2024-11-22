<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PacienteRegisterRequest extends FormRequest
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
            'NomPac' => 'required|string|max:255',
            'ApePatPac' => 'required|string|max:255',
            'ApeMatPac' => 'required|string|max:255',
            'FechaNacPac' => 'required|date',
            'GenPac' => 'required|string|max:255',
            'DirPac' => 'required|string|max:255',
            'TelPac' => 'required|string|max:255',
            'FechPac' => 'required|date',
            'email' => 'required|email|unique:paciente,email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ]
        ];
    }
}
