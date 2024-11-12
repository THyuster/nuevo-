<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NominaCargosRequest extends FormRequest
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
            '*' => 'prohibited',
            'nombre' => 'required|string|max:100',
            'requisitos_minimos_puesto' => 'required|string',
            'descripcion_puesto' => 'required|string',
            'salario_puesto' => 'required|integer',
            'codigo_cargo' => 'required|string|max:45',
        ];
    }
}
