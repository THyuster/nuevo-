<?php

namespace App\Http\Requests\Erp;

use Illuminate\Foundation\Http\FormRequest;

class AdminValidation extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'cliente_id' => 'required|string',
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

            'cliente_id.required' => 'El campo Cliente es obligatorio.',
        ];
    }
}