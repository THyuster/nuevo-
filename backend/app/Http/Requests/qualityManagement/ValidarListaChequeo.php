<?php

namespace App\Http\Requests\qualityManagement;

use Illuminate\Foundation\Http\FormRequest;

class ValidarListaChequeo extends FormRequest
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
            'codigo' => 'required|string',
            'descripcion' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'codigo.required' => 'El campo codigo es obligatorio.',


            'descripcion.required' => 'El campo descripcion es obligatorio.',
            'descripcion.string' => 'El campo descripcion debe ser texto.',

        ];
    }
}