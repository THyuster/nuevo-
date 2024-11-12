<?php

namespace App\Http\Requests\modulo_contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class FiscalYearValidation extends FormRequest
{

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
            'descripcion' => 'required|string',
            'afiscal' => 'required|integer|digits:4'
        ];
    }
    public function messages()
    {
        return [
            'descripcion.required' => 'El campo Descripción es obligatorio.',
            'afiscal.required' => 'El año fiscal es obligatorio.',
        ];
    }
}