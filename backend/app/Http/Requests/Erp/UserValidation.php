<?php

namespace App\Http\Requests\Erp;

use Illuminate\Foundation\Http\FormRequest;

class UserValidation extends FormRequest
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
            '*' => 'prohibited',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'tipo_cargo' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre es obligatorio.',
            'name.string' => 'El campo Nombre debe ser una cadena de texto.',

            'email.required' => 'El campo Email es obligatorio.',
            'email.string' => 'El campo Email debe ser una cadena de texto.',

            'password.required' => 'El campo Contraseña es obligatorio.',
            'password.string' => 'El campo Contraseña debe ser una cadena de texto.',

            'companiesId.required' => 'La empresa es obligatoria',

        ];
    }
}
