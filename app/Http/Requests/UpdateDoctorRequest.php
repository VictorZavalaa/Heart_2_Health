<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateDoctorRequest extends FormRequest
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
            'NomDoc' => 'required|string|max:255',
            'ApePatDoc' => 'required|string|max:255',
            'ApeMatDoc' => 'required|string|max:255',
            'FechNacDoc' => 'required|date',
            'GenDoc' => 'required|string|max:255',
            'DirDoc' => 'required|string|max:255',
            'TelDoc' => 'required|string|max:255',
            'Especialidad' => 'required|string|max:255',
            'FechDoc' => 'required|date',
            'email' => 'required|email',
            'password' => [
                'nullable',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ]
        ];
    }
}
