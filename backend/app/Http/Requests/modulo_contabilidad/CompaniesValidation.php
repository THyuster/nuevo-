<?php

namespace App\Http\Requests\modulo_contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesValidation extends FormRequest
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
            'nit' => 'required',
            'razon_social' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|digits:10',
            'email' => 'required|email',
            'cliente_id' => 'required',
            'ruta_imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ];
    }
    public function messages()
    {
        return [
            'tercero_id.required' => 'El ID del tercero es obligatorio.',
            'razon_social.required' => 'El campo Razón Social es obligatorio.',
            'direccion.required' => 'El campo Dirección es obligatorio.',
            'telefono.required' => 'El campo Teléfono es obligatorio.',
            'telefono.integer' => 'El campo Teléfono debe ser un número.',
            'email.required' => 'El campo Email es obligatorio.',
            'email.email' => 'El campo Email debe ser una dirección de correo electrónico válida.',
            'telefono.digits' => 'El  Teléfono debe contener exactamente 10 dígitos.',
            'cliente_id.required' => 'El cliente y/o o grupo empresarial  es obligatorio.',
            'imagen.required' => 'La imagen  es obligatorio.',
        ];
    }
}