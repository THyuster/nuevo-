<?php

namespace App\Http\Requests\Logistica_Vehiculos\Vehiculos;

use App\Rules\ValidStringOrImage;
use Illuminate\Foundation\Http\FormRequest;

class VehiculosRequestCreate extends FormRequest
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
            'tercero_propietario_id' => 'required|string|max:20',
            'tercero_conductor_id' => 'nullable|string|max:20',
            'fecha_afiliacion' => 'required|date',
            'fecha_desvinculacion' => 'nullable|date',
            'fecha_operacion' => 'nullable|date',
            'propio' => 'required|bool',
            'modificado' => 'required|bool',
            'tipo_vehiculo_id' => 'required|integer',
            'logistica_grupo_vehiculo_id' => 'nullable|numeric',
            'logistica_tipo_contrato_id' => 'nullable|numeric',
            'combustible_id' => 'required|numeric',
            'blindaje_id' => 'required|numeric',
            'logistica_ejes_id' => 'required|numeric',
            'observaciones' => 'nullable|string',
            'tipo_servicio_id' => 'required|string|max:50',
            'codigo_interno' => 'required|string|max:100',
            'licencia_propiedad' => 'required|string|max:100',
            'centro_trabajo_id' => 'nullable|numeric',
            'placa' => 'required|string|max:10',
            'marca_id' => 'required|numeric',
            'modelo' => 'required|string|max:20',
            'linea_id' => 'required|string|max:100',
            'color_id' => 'required|string|max:100',
            'serial_motor' => 'nullable|string|max:100',
            'serial_chasis' => 'nullable|string|max:100',
            'serial_vin' => 'nullable|string|max:100',
            'trailer_id' => 'nullable|numeric',
            'modelo_trailer' => 'nullable|string|max:50',
            'capacidad_kg_psj' => 'nullable|string|max:50',
            'capacidad_ton' => 'nullable|string|max:50',
            'cilindraje' => 'nullable|string|max:50',
            'tara_vehiculo' => 'nullable|string|max:50',
            'pasajeros' => 'nullable|string|max:50',
            'kilometraje_ini' => 'nullable|string|max:50',
            'horometro_ini' => 'nullable|string|max:50',
            'potencia_hp' => 'nullable|string|max:50',
            'fecha_compra' => 'nullable|date',
            'valor_comercial' => 'nullable|string|max:100',
            'soat_empresa' => 'nullable|string|max:200',
            'soat_valor' => 'nullable|string|max:200',
            'soat_fecha_ini' => 'nullable|date',
            'soat_fecha_fin' => 'nullable|date',
            'gps_empresa' => 'nullable|string|max:100',
            'gps_usuario' => 'nullable|string|max:100',
            'gps_contrasena' => 'nullable|string|max:100',
            'gps_id' => 'nullable|string|max:100',
            'gps_numero' => 'nullable|string|max:100',
            'gases_empresa' => 'nullable|string|max:200',
            'gases_valor' => 'nullable|string|max:200',
            'gases_fecha_ini' => 'nullable|date',
            'gases_fecha_fin' => 'nullable|date',
            'seguro_empresa' => 'nullable|string|max:200',
            'numero_seguro' => 'nullable|string|max:100',
            'seguro_valor' => 'nullable|string|max:200',
            'seguro_fecha_ini' => 'nullable|date',
            'seguro_fecha_fin' => 'nullable|date',
            'ruta_imagen' => ['nullable', new ValidStringOrImage],
            'ruta_ficha_tecnica' => 'nullable|string|max:200',
            // 'estado' => 'nullable|boolean',
            'todo_riesgo_empresa' => 'nullable|string|max:200',
            'numero_todo_riesgo' => 'nullable|string|max:100',
            'todo_riesgo_valor' => 'nullable|string|max:200',
            'todo_riesgo_fecha_ini' => 'nullable|date',
            'todo_riesgo_fecha_fin' => 'nullable|date',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'propio' => filter_var($this->input('propio'), FILTER_VALIDATE_BOOLEAN),
            'modificado' => filter_var($this->input('modificado'), FILTER_VALIDATE_BOOLEAN),
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
