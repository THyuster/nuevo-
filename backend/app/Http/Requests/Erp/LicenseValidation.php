<?php

namespace App\Http\Requests\Erp;

use Illuminate\Foundation\Http\FormRequest;

class LicenseValidation extends FormRequest
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
            'cliente_id' => 'required|int|min:1',
            'empresa_id' => 'required|string',
            'codigo' => 'required|string',
            'descripcion' => 'required|string',
            'fecha_inicial' => 'required|date',
            'fecha_final' => 'required|date',
            'modulo_id'  => 'required|array',
        ];
    }
    public function messages()
    {
        return [
            'cliente_id.required' => 'El  cliente es obligatorio.',
            'cliente_id.int' => 'La identificacion del cliente debe ser un numerica.',
            'codigo.required' => 'El código es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'fecha_inicial.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicial.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_final.required' => 'La fecha final es obligatoria.',
            'fecha_final.date' => 'La fecha final debe ser una fecha válida.',
            'empresa_id.required' => 'El  cliente es obligatorio.',
            'cliente_id.min' => 'Obligatorio el cliente',


        ];
    }
}
