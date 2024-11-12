<?php

namespace App\Http\Requests\modulo_contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class ThirdValidation extends FormRequest
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
            'nombre1' => 'string',
            'apellido1' => 'string',
            'identificacion' => 'required|string',
            'fecha_nacimiento' => 'required',
            // 'tipo_tercero_id' => 'required|array',
            'tipo_identificacion' => 'required|string',
            'naturaleza_juridica' => 'required|string',
            'telefono_fijo' => 'nullable|numeric',
            'movil' => 'nullable|numeric|digits:10',
            'email' => 'nullable|email',
            'municipio' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'nombre1.required' => 'El campo nombre es obligatorio.',
            'apellido1.required' => 'El campo apellido es obligatorio.',
            'identificacion.required' => 'El campo identificación es obligatorio.',
            'tipo_tercero.required' => 'Debe seleccionar al menos un tipo de tercero.',
            'tipo_identificacion.required' => 'El campo tipo de identificación es obligatorio.',
            'naturaleza_juridica.required' => 'El campo naturaleza jurídica es obligatorio.',
            'telefono_fijo.numeric' => 'El campo teléfono fijo debe ser un número.',
            'movil.numeric' => 'El campo móvil debe ser un número.',
            'movil.digits' => 'El campo móvil debe tener 10 dígitos.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'municipio.required' => 'El campo municipio es obligatorio.',
        ];
    }
}
