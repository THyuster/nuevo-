<?php

namespace App\Http\Requests\inventory;


use Illuminate\Foundation\Http\FormRequest;

class ArticleValidation extends FormRequest
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
            'IPUU' => 'nullable|boolean',
            'iva_mayor_costo' => 'nullable|boolean',
            'codigo' => 'required|string',
            'codigo_barras' => 'required|string',
            'costo_informativo' => 'required|numeric',
            'costo_promedio_actual' => 'required|numeric',
            'costo_promedio_fisico' => 'required|numeric',
            'departamento_id' => 'required|min:1',
            'descripcion' => 'required|string',
            'existencia_actual' => 'required|numeric',
            'existencia_maxima' => 'required|numeric',
            'existencia_minima' => 'required|numeric',
            'factor' => 'required|string',
            'factor_global' => 'required|numeric',
            'ultima_fecha_transaccional' => 'required|date',
            'ultimo_costo_compra' => 'required|numeric',
            'grupo_articulo_id' => 'required|min:1',
            'grupo_contable_id' => 'required|min:1',
            'impuesto_consumo' => 'required|numeric',
            'linea_id' => 'required|min:1',
            'marca_id' => 'required|min:1',
            'material_exportacion' => 'required',
            'modelo' => 'required|string',
            'observaciones' => 'required|string',
            'referencia' => 'required|string',
            'tipo_bien' => 'required|string',
            'tipo_material' => 'required|string',
            'tipo_serial' => 'required|string',
            'tipo_unidad_id' => 'required',
            'ultimo_costo_promedio' => 'required|numeric',
            'porc_utilidad_costo' => 'required|numeric',
            'porc_utilidad_costo_promedio' => 'required|numeric',
            'valor_unitario' => 'required|numeric',
            'talla_id' => 'required|min:1',
            'color_id' => 'required|min:1',
            'ruta_imagen' => 'required|image|mimes:jpeg,png|max:2048',
            'ruta_ficha_tecnica' => 'required|image|mimes:jdf|max:2048',

        ];
    }
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'boolean' => 'El campo :attribute debe ser verdadero o falso.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'min' => [
                'numeric' => 'El campo :attribute debe ser al menos :min.',
                'file' => 'El tamaño del archivo :attribute debe ser al menos :min kilobytes.',
                'string' => 'El campo :attribute debe tener al menos :min caracteres.',
                'array' => 'El campo :attribute debe tener al menos :min elementos.',
            ],
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'image' => 'El campo :attribute debe ser una imagen.',
            'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
            'max' => [
                'numeric' => 'El campo :attribute no debe ser mayor a :max.',
                'file' => 'El tamaño del archivo :attribute no debe ser mayor a :max kilobytes.',
                'string' => 'El campo :attribute no debe tener más de :max caracteres.',
                'array' => 'El campo :attribute no debe tener más de :max elementos.',
            ],
        ];
    }



}
