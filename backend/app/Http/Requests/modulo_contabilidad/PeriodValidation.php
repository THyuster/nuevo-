<?php

namespace App\Http\Requests\modulo_contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class PeriodValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'codigo' => 'required',
            'afiscal_id' => 'required|string',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date',
          
        ];
    }
    public function messages()
    {
        return [
            'codigo.required' => 'El campo Código es obligatorio.',
            'afiscal_id.required' => 'El ID del año fiscal es obligatorio.',
            'afiscal_id.string' => 'El ID del año fiscal debe ser una cadena de caracteres.',
            'descripcion.required' => 'El campo Descripción es obligatorio.',
            'descripcion.string' => 'El campo Descripción debe ser una cadena de caracteres.',
            'fecha_inicio.required' => 'El campo Fecha de inicio es obligatorio.',
            'fecha_inicio.date' => 'El campo Fecha de inicio debe ser una fecha válida.',
            'fecha_final.required' => 'El campo Fecha final es obligatorio.',
            'fecha_final.date' => 'El campo Fecha final debe ser una fecha válida.',
        ];
    }
}
