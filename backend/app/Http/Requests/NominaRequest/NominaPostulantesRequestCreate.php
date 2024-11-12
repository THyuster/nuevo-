<?php

namespace App\Http\Requests\NominaRequest;

use Illuminate\Foundation\Http\FormRequest;

class NominaPostulantesRequestCreate extends FormRequest
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
            //
            '*' => 'prohibited',
            'empId' => 'nullable',
            'nomina_convocatoria_id' => 'required',
            'tipo_identificacion' => 'required',
            'identificacion' => 'required',
            'nombre1' => 'required',
            'nombre2' => 'nullable',
            'apellido1' => 'required',
            'apellido2' => 'nullable',
            'fecha_nacimiento' => 'required',
            'lugar_nacimiento' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'direccion' => 'required',
            'departamento' => 'required',
            'municipio' => 'required',
            'estado_civil' => 'nullable',
            'ruta_foto_perfil' => 'nullable|string',
            'sexo' => 'required',
            'tipo_sangre' => 'required',
            'tipo_vivienda' => 'required',
            'complementarios' => 'required|array',
            'complementarios.*.aspiracion_ingresos' => 'required|numeric',
            'complementarios.*.licencias_conduccion' => 'required|bool',
            'complementarios.*.nivel_ingles' => 'required|string',
            'complementarios.*.habilidades_informaticas' => 'required|string',
            'complementarios.*.inmediatez_inicial' => 'required|string',
            'complementarios.*.paises_visitados' => 'required|string',
            'complementarios.*.estatura' => 'required|string',
            'complementarios.*.peso' => 'required|string',
            'complementarios.*.deporte' => 'required|bool',
            'complementarios.*.fuma' => 'required|bool',
            'complementarios.*.alcohol' => 'required|bool',
            'complementarios.*.vehiculo_propio' => 'required|bool',
            'complementarios.*.tipo_vehiculo' => 'required|string',
            'academias' => 'required|array',
            'academias.*.institucion' => 'required|string',
            'academias.*.titulo_obtenido' => 'required|string',
            'academias.*.fecha_inicial' => 'required|date',
            'academias.*.fecha_final' => 'nullable|date',
            'academias.*.ciudad' => 'required|string',
            'experiencias_laborales' => 'required|array',
            'experiencias_laborales.*.empresa' => 'required|string',
            'experiencias_laborales.*.cargo' => 'required|string',
            'experiencias_laborales.*.jefe' => 'required|string',
            'experiencias_laborales.*.telefono' => 'required|string',
            'experiencias_laborales.*.responsabilidades' => 'required|string',
            'experiencias_laborales.*.fecha_inicio' => 'required|date',
            'experiencias_laborales.*.fecha_fin' => ' nullable|date',
            'relaciones_personales' => 'required|array',
            'relaciones_personales.*.nombre_completo' => 'required|string',
            'relaciones_personales.*.telefono' => 'required|string',
            'relaciones_personales.*.relacion' => 'required|string',
            'relaciones_personales.*.direccion' => 'required|string',
            'relaciones_familiares' => 'required|array',
            'relaciones_familiares.*.nombre_completo' => 'required|string',
            'relaciones_familiares.*.telefono' => 'required|string',
            'relaciones_familiares.*.parentesco' => 'required|string',
            'relaciones_familiares.*.direccion' => 'required|string',
        ];
    }
}
