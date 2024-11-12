<?php

namespace App\Http\Requests\qualityManagement;

use Illuminate\Foundation\Http\FormRequest;

class QualityManagementValidation extends FormRequest
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
            'nomina_centro_trabajo_id' => 'required|int',
            'users_id' => 'required|int',
            'tipo_solicitud_id' => 'required|int',
            'fecha_auditoria' => 'required|string',
            'fecha_plazo' => 'required|string',
            'requerimiento' => 'required|string',
            'estado_id' => 'required|int',

        ];
    }
    public function messages()
    {
        return [
            'nomina_centro_trabajo_id.required' => 'El campo centro de trabajo es obligatorio.',
            'nomina_centro_trabajo_id.int' => 'El campo centro de trabajo debe ser un número entero.',

            'users_id.required' => 'El campo usuario es obligatorio.',
            'users_id.int' => 'El campo usuario debe ser un número entero.',

            'tipo_solicitud_id.required' => 'El campo tipo de solicitud es obligatorio.',
            'tipo_solicitud_id.int' => 'El campo tipo de solicitud debe ser un número entero.',

            'fecha_auditoria.required' => 'El campo fecha de auditoría es obligatorio.',
            'fecha_auditoria.string' => 'El campo fecha de auditoría debe ser una cadena de texto.',

            'fecha_plazo.required' => 'El campo fecha de plazo es obligatorio.',
            'fecha_plazo.string' => 'El campo fecha de plazo debe ser una cadena de texto.',

            'requerimiento.required' => 'El campo requerimiento es obligatorio.',
            'requerimiento.string' => 'El campo requerimiento debe ser una cadena de texto.',

            'estado_id.required' => 'El campo estado es obligatorio.',
            'estado_id.int' => 'El campo estado debe ser un número entero.',

        ];
    }
}