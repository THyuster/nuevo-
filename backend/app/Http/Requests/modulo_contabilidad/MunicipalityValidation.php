<?php

namespace App\Http\Requests\modulo_contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class MunicipalityValidation extends FormRequest
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
            'codigo' => 'required|string',
            'descripcion' => 'required|string',
            'departamento_id' => 'required|numeric|min:1',

        ];
    }
    public function messages()
    {
        return [
            'codigo.required' => 'El campo codigo es obligatorio.',
            'descripcion.required' => 'El campo descripcion es obligatorio.',
            'departamento_id.required' => 'El campo departamento es obligatorio.',
            'departamento_id.min' => 'El campo departamento es obligatorio.',

        ];
    }
}
