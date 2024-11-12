<?php

namespace App\Http\Requests\modulo_contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class BranchValidation extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {

        return [
            'codigo' => 'required',
            'descripcion' => 'required|string',
            'municipio_id' => 'required|string',
            // 'empresa_id' => 'required|int',

        ];
    }
    public function messages() {
        return [
            'codigo.required' => 'El campo Código es obligatorio.',
            'descripcion.required' => 'El campo Descripción es obligatorio.',
            'municipio_id.required' => 'El campo Municipio es obligatorio.',
            // 'empresa_id.required' => 'El campo Empresa es obligatorio.',
        ];
    }
}
