<?php

namespace App\Http\Requests\accountingModule;

use Illuminate\Foundation\Http\FormRequest;

class ModuleAssignmentValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            '*' => 'prohibited',
            'modulo' => 'required|string',
            'userId' => 'required|int',
            'moduloId' => 'required|int',
            'empresaId' => 'required|int',

        ];
    }
    public function messages()
    {
        return [

            'userId.required' => 'El campo userId es obligatorio.',

            'moduloId.required' => 'El campo moduloId es obligatorio.',

            'empresaId.required' => 'El campo empresaId es obligatorio.',

        ];
    }
}