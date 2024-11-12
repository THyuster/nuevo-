<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NominaConvocatoriasCrearPorSolicitudEmpleoRequest extends FormRequest
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
            "*" => 'prohibited',
            "fecha_apertura" => 'required|date',
            "fecha_cierre" => 'required|date',
            "nomina_solicitudes_empleo_id" => 'required|integer',
            "numero_puestos" => 'required|integer|min:1',
        ];
        
    }

    public function messages()
    {
        return [
            'prohibited' => 'El campo :attribute no es permitido.',
            'required' => 'El campo :attribute es obligatorio.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'min' => 'El campo requiere un valor mínimo de :min'
        ];
    }
}
