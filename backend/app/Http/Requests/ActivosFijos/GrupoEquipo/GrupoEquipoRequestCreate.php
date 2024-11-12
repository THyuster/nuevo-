<?php

namespace App\Http\Requests\ActivosFijos\GrupoEquipo;

use Illuminate\Foundation\Http\FormRequest;

class GrupoEquipoRequestCreate extends FormRequest
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
            //
            '*' => 'prohibited',
            'descripcion' => 'required|string',
            'codigo' => 'required|string'
        ];
    }
}
