<?php

namespace App\Http\Requests\Erp;

use Illuminate\Foundation\Http\FormRequest;

class
ClientValidation extends FormRequest
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
            'nit' => 'required|string',
            'telefono' => 'required|string',
            'direccion' => 'required|string',

            'ruta_imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',


        ];
    }
    public function messages()
    {
        return [
            'codigo.required' => 'El campo Código es obligatorio.',
            'codigo.string' => 'El campo Código debe ser una cadena de texto.',

            'descripcion.required' => 'El campo Descripción es obligatorio.',
            'descripcion.string' => 'El campo Descripción debe ser una cadena de texto.',

            'nit.required' => 'El campo nit es obligatorio.',
            'nit.string' => 'El campo nit debe ser una cadena de texto.',

            'telefono.required' => 'El campo telefono es obligatorio.',
            'telefono.string' => 'El campo telefono debe ser una cadena de texto.',

            'tercero.required' => 'El Tercero es obligatorio es obligatorio.',

            'direccion.required' => 'El campo direccion es obligatorio.',
            'direccion.string' => 'El campo direccion debe ser una cadena de texto.',

            'ruta_imagen.required' => 'Debe seleccionar una imagen para subir.',


        ];
    }
}
