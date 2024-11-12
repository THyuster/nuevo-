<?php

namespace App\Http\Requests\Erp;

use Illuminate\Foundation\Http\FormRequest;

class RoleAssignmentValidation extends FormRequest
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

            'userId' => 'required|int',
            'companieId' => 'required|int',
            'roleId' => 'required|int'


        ];
    }
    public function messages()
    {
        return [
            'userId.required' => 'El campo userId es obligatorio.',
            'userId.string' => 'El campo userId debe ser una cadena de texto.',

            'companieId.required' => 'El campo companieId es obligatorio.',
            'companieId.string' => 'El campo companieId debe ser una cadena de texto.',

            'roleId.required' => 'El campo roleId es obligatorio.',
            'roleId.string' => 'El campo roleId debe ser una cadena de texto.',



        ];
    }
}