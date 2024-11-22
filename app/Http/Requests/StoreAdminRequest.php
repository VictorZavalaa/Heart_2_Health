<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreAdminRequest extends FormRequest
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
            'NomAdmin' => 'required|string|max:255',
            'ApePatAdmin' => 'required|string|max:255',
            'ApeMatAdmin' => 'required|string|max:255',
            'FechaNacAdmin' => 'required|date',
            'TelAdmin' => 'required|string|max:10',
            'FechAdmin' => 'required|date',
            'email' => 'required|email|unique:administrador,email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
            ]
        ];
    }
}
