<?php

namespace App\Http\Requests\fixedAssets;


use Illuminate\Foundation\Http\FormRequest;

class FixedAssetsValidation extends FormRequest
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
            'grupo_equipo_id' => 'required|string',
            'descripcion' => 'required|string',
            'fecha_adquisicion' => 'required|date',
            'fecha_instalacion' => 'required|date',
            'serial_interno' => 'required|string',
            'serial_equipo' => 'required|string',
            'modelo' => 'required|string',
            'marcaId' => 'required|string',
            'potencia' => 'required|string',
            'proveedorId' => 'required|string',
            'mantenimiento' => 'required|string',
            'horometro' => 'required|numeric|min:0',
            'costo' => 'required|numeric',
            'combustible' => 'required|string',
            'uso_diario' => 'required|string',
            'upm' => 'required|string',
            'area' => 'required|string',
            'labor' => 'required|string',
            'administradorId' => 'required|string',
            'ingenieroId' => 'required|string',
            'jefe_mantenimiento_id' => 'required|string',
            'operador_id' => 'required|string',
            'observaciones' => 'required|string',
            'ruta_imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            
        ];
    }
    public function messages()
    {
        return [
            'codigo.required' => 'El campo Código es obligatorio.',
            'codigo.string' => 'El campo Código debe ser una cadena de texto.',
            'grupo_equipo_id.required' => 'El campo Grupo Equipo es obligatorio.',
            'grupo_equipo_id.int' => 'El campo Grupo Equipo debe ser un número entero.',
            'descripcion.required' => 'El campo Descripción es obligatorio.',
            'descripcion.string' => 'El campo Descripción debe ser una cadena de texto.',
            'fecha_adquisicion.required' => 'El campo Fecha de Adquisición es obligatorio.',
            'fecha_adquisicion.date' => 'El campo Fecha de Adquisición debe ser una fecha válida.',
            'fecha_instalacion.required' => 'El campo Fecha de Instalación es obligatorio.',
            'fecha_instalacion.date' => 'El campo Fecha de Instalación debe ser una fecha válida.',
            'serial_interno.required' => 'El campo Serial Interno es obligatorio.',
            'serial_interno.string' => 'El campo Serial Interno debe ser una cadena de texto.',
            'serial_equipo.required' => 'El campo Serial Equipo es obligatorio.',
            'serial_equipo.string' => 'El campo Serial Equipo debe ser una cadena de texto.',
            'modelo.required' => 'El campo Modelo es obligatorio.',
            'modelo.string' => 'El campo Modelo debe ser una cadena de texto.',
            'marcaId.required' => 'El campo Marca es obligatorio.',
            'marcaId.int' => 'El campo Marca debe ser un número entero.',
            'potencia.required' => 'El campo Potencia es obligatorio.',
            'potencia.string' => 'El campo Potencia debe ser una cadena de texto.',
            'proveedorId.required' => 'El campo Proveedor es obligatorio.',
            'proveedorId.int' => 'El campo Proveedor debe ser un número entero.',
            'mantenimiento.required' => 'El campo Mantenimiento es obligatorio.',
            'mantenimiento.string' => 'El campo Mantenimiento debe ser una cadena de texto.',
            'horometro.required' => 'El campo Horómetro es obligatorio.',
            'horometro.numeric' => 'El campo Horómetro debe ser un valor numérico.',
            'horometro.min' => 'El campo Horómetro debe ser mayor o igual a cero.',
            'costo.required' => 'El campo Costo es obligatorio.',
            'costo.numeric' => 'El campo Costo debe ser un valor numérico.',
            'combustible.required' => 'El campo Combustible es obligatorio.',
            'combustible.string' => 'El campo Combustible debe ser una cadena de texto.',
            'uso_diario.required' => 'El campo Uso Diario es obligatorio.',
            'uso_diario.string' => 'El campo Uso Diario debe ser una cadena de texto.',
            'upm.required' => 'El campo UPM es obligatorio.',
            'upm.string' => 'El campo UPM debe ser una cadena de texto.',
            'area.required' => 'El campo Área es obligatorio.',
            'area.string' => 'El campo Área debe ser una cadena de texto.',
            'labor.required' => 'El campo Labor es obligatorio.',
            'labor.string' => 'El campo Labor debe ser una cadena de texto.',
            'administradorId.required' => 'El campo Administrador es obligatorio.',
            'administradorId.int' => 'El campo Administrador debe ser un número entero.',
            'ingenieroId.required' => 'El campo Ingeniero es obligatorio.',
            'ingenieroId.int' => 'El campo Ingeniero debe ser un número entero.',
            'jefe_mantenimiento_id.required' => 'El campo Jefe de Mantenimiento es obligatorio.',
            'jefe_mantenimiento_id.int' => 'El campo Jefe de Mantenimiento debe ser un número entero.',
            'operador_id.required' => 'El campo Operador es obligatorio.',
            'operador_id.int' => 'El campo Operador debe ser un número entero.',
            'observaciones.required' => 'El campo Observaciones es obligatorio.',
            'observaciones.string' => 'El campo Observaciones debe ser una cadena de texto.',
            'ruta_imagen.required' => 'El campo Ruta de Imagen es obligatorio.',
            'ruta_imagen.image' => 'El archivo debe ser una imagen.',
            'ruta_imagen.mimes' => 'El archivo debe tener un formato de imagen válido (jpeg, png, jpg).',
            'ruta_imagen.max' => 'El tamaño máximo del archivo de imagen es de 2048 KB.',
        ];
    }
    
   
}
