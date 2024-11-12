<?php

namespace App\Data\Dtos\Empleados\Requests\Empleado;


class EmpleadoCreateDTO
{
    public $empleadoId;
    public $convocatoriaRelId;
    // public $createdAt;
    // public $updatedAt;
    public $tipoIdentificacion;
    public $identificacion;
    public $nombre1;
    public $nombre2;
    public $apellido1;
    public $apellido2;
    public $fechaNacimiento;
    public $lugarNacimiento;
    public $edad;
    public $email;
    public $telefono;
    public $direccion;
    public $departamento;
    public $municipio;
    public $estadoCivil;
    public $rutaFotoPerfil;
    public $sexo;
    public $tipoSangre;
    public $tipoVivienda;
    public function __construct(array $data = [])
    {
        $this->empleadoId = $data['empleado_id'] ?? null;
        $this->convocatoriaRelId = $data['convocatoria__rel_id'] ?? null;
        $this->tipoIdentificacion = $data['tipo_identificacion'] ?? null;
        $this->identificacion = $data['identificacion'] ?? null;
        $this->nombre1 = $data['nombre1'] ?? null;
        $this->nombre2 = $data['nombre2'] ?? null;
        $this->apellido1 = $data['apellido1'] ?? null;
        $this->apellido2 = $data['apellido2'] ?? null;
        $this->fechaNacimiento = $data['fecha_nacimiento'] ?? null;
        $this->lugarNacimiento = $data['lugar_nacimiento'] ?? null;
        $this->edad = $data['edad'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->telefono = $data['telefono'] ?? null;
        $this->direccion = $data['direccion'] ?? null;
        $this->departamento = $data['departamento'] ?? null;
        $this->municipio = $data['municipio'] ?? null;
        $this->estadoCivil = $data['estado_civil'] ?? null;
        $this->rutaFotoPerfil = $data['ruta_foto_perfil'] ?? null;
        $this->sexo = $data['sexo'] ?? null;
        $this->tipoSangre = $data['tipo_sangre'] ?? null;
        $this->tipoVivienda = $data['tipo_vivienda'] ?? null;
    }

    public static function createFromModel($model)
    {
        return new self([
            'empleado_id' => $model->empleado_id ?? null,
            'convocatoria__rel_id' => $model->convocatoria__rel_id ?? null,
            // 'created_at' => $model->created_at ?? null,
            // 'updated_at' => $model->updated_at ?? null,
            'tipo_identificacion' => $model->tipo_identificacion ?? null,
            'identificacion' => $model->identificacion ?? null,
            'nombre1' => $model->nombre1 ?? null,
            'nombre2' => $model->nombre2 ?? null,
            'apellido1' => $model->apellido1 ?? null,
            'apellido2' => $model->apellido2 ?? null,
            'fecha_nacimiento' => $model->fecha_nacimiento ?? null,
            'lugar_nacimiento' => $model->lugar_nacimiento ?? null,
            'edad' => $model->edad ?? null,
            'email' => $model->email ?? null,
            'telefono' => $model->telefono ?? null,
            'direccion' => $model->direccion ?? null,
            'departamento' => $model->departamento ?? null,
            'municipio' => $model->municipio ?? null,
            'estado_civil' => $model->estado_civil ?? null,
            'ruta_foto_perfil' => $model->ruta_foto_perfil ?? null,
            'sexo' => $model->sexo ?? null,
            'tipo_sangre' => $model->tipo_sangre ?? null,
            'tipo_vivienda' => $model->tipo_vivienda ?? null,
        ]);
    }

    public function toArray()
    {
        return [
            'empleado_id' => $this->empleadoId,
            'convocatoria__rel_id' => $this->convocatoriaRelId,
            'tipo_identificacion' => $this->tipoIdentificacion,
            'identificacion' => $this->identificacion,
            'nombre1' => $this->nombre1,
            'nombre2' => $this->nombre2,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'fecha_nacimiento' => $this->fechaNacimiento,
            'lugar_nacimiento' => $this->lugarNacimiento,
            'edad' => $this->edad,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'departamento' => $this->departamento,
            'municipio' => $this->municipio,
            'estado_civil' => $this->estadoCivil,
            'ruta_foto_perfil' => $this->rutaFotoPerfil,
            'sexo' => $this->sexo,
            'tipo_sangre' => $this->tipoSangre,
            'tipo_vivienda' => $this->tipoVivienda,
        ];
    }
}
