<?php

namespace App\Http\Requests\ActivosFijos\Equipos;

use App\Rules\ValidStringOrImage;
use Illuminate\Foundation\Http\FormRequest;

class EquipoRequestCreate extends FormRequest
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
            'codigo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:200',
            'grupo_equipo_id' => 'required|string',
            'fecha_adquisicion' => 'required|date',
            'fecha_instalacion' => 'nullable|date',
            'serial_interno' => 'nullable|string|max:100',
            'serial_equipo' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'marcaId' => 'required|integer',
            'potencia' => 'nullable|string|max:100',
            'proveedorId' => 'required|integer',
            'mantenimiento' => 'required|string|max:100',
            'horometro' => 'nullable|numeric|between:0,99999999.99',
            'costo' => 'nullable|numeric|between:0,99999999.99',
            'combustible' => 'nullable|string|max:100',
            'uso_diario' => 'nullable|integer|between:0,18446744073709551615', // Ajustar según el rango de uso_diario
            'upm' => 'required|integer',
            'area' => 'nullable|string|max:100',
            'labor' => 'nullable|string|max:100',
            'administradorId' => 'nullable|integer',
            'ingenieroId' => 'nullable|integer',
            'jefe_mantenimiento_id' => 'nullable|integer',
            'operador_id' => 'nullable|integer',
            'observaciones' => 'nullable|string|max:300',
            'ruta_imagen' => ['nullable', new ValidStringOrImage],
            'peso_kgs' => 'nullable|string|max:50',
            'altura_mts' => 'nullable|string|max:50',
            'ancho_mts' => 'nullable|string|max:50',
            'largo_mts' => 'nullable|string|max:50',
            'temp_centigrados' => 'nullable|string|max:50',
            'rpm' => 'nullable|string|max:50',
            'inventario_unidad_id' => 'nullable|integer',
            'cabinado' => 'required|bool'
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'cabinado' => filter_var($this->input('cabinado'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function messages()
    {
        return [
            'prohibited' => 'El campo :attribute no es permitido.',
            'required' => 'El campo :attribute es obligatorio',
            'string' => 'El campo :attribute debe ser una cadena de texto',
            'nullable' => 'El campo :attribute es opcional',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'bool' => 'El campo :attribute debe ser true o false.'
        ];
    }
}
