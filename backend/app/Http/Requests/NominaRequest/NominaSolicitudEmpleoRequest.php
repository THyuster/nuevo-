<?php

namespace App\Http\Requests\NominaRequest;

use Illuminate\Foundation\Http\FormRequest;

class NominaSolicitudEmpleoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*' => 'prohibited',
            'user_id' => 'required|string|min:1',
            'nomina_centro_trabajo_id' => 'required|integer|min:1',
            'nomina_cargo_id' => 'required|integer|min:1',
            'estado_prioridad_id' => 'required|integer|min:1',
            'numero_puestos' => 'required|integer|min:1',
            'observacion_solicitud' => 'required|string',
        ];
    }
}
