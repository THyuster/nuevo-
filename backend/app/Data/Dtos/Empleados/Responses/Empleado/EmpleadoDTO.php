<?php

namespace App\Data\Dtos\Empleados\Responses\Empleado;
use App\Data\Dtos\Empleados\Responses\Empleado\Details\EmpleadoAcademicoDTO;
use App\Data\Dtos\Empleados\Responses\Empleado\Details\EmpleadoComplementarioDTO;
use App\Data\Dtos\Empleados\Responses\Empleado\Details\EmpleadoExperienciaLaboralDTO;
use App\Data\Dtos\Empleados\Responses\Empleado\Details\EmpleadoFamiliaresDTO;
use App\Data\Dtos\Empleados\Responses\Empleado\Details\EmpleadoPersonalesDTO;
use App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Response\SagrilaftEmpleadoRelUrlDTO;

class EmpleadoDTO
{
    public $empleadoId;
    public $convocatoriaRelId;

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
    // public $departamento;
    // public $municipio;
    public $estadoCivil;
    public $rutaFotoPerfil;
    public $sexo;
    public $tipoSangre;
    public $tipoVivienda;
    /**
     * @var array<EmpleadoAcademicoDTO>
     */
    public $academias = [];
    /**
     * @var array<EmpleadoExperienciaLaboralDTO>
     */
    public $experienciaLaboral = [];
    /**
     * @var array<EmpleadoFamiliaresDTO>
     */
    public $familiares = [];
    /**
     * @var array<EmpleadoPersonalesDTO>
     */
    public $personales = [];
    /**
     * @var array<EmpleadoComplementarioDTO>
     */
    public $complementarios = [];
    public $validaciones;
    public $createdAt;
    public $updatedAt;
    public function __construct($data = null)
    {
        $this->empleadoId = $data->empleado_id ?? null;
        $this->convocatoriaRelId = $data->convocatoria__rel_id ?? null;
        $this->tipoIdentificacion = $data->tipo_identificacion ?? null;
        $this->identificacion = $data->identificacion ?? null;
        $this->nombre1 = $data->nombre1 ?? null;
        $this->nombre2 = $data->nombre2 ?? null;
        $this->apellido1 = $data->apellido1 ?? null;
        $this->apellido2 = $data->apellido2 ?? null;
        $this->fechaNacimiento = $data->fecha_nacimiento ?? null;
        $this->lugarNacimiento = $data->lugar_nacimiento ?? null;
        $this->edad = $data->edad ?? null;
        $this->email = $data->email ?? null;
        $this->telefono = $data->telefono ?? null;
        $this->direccion = $data->direccion ?? null;
        // $this->departamento = $data->departamento ?? null;
        // $this->municipio = $data->municipio ?? null;
        $this->estadoCivil = $data->estado_civil ?? null;
        $this->rutaFotoPerfil = $data->ruta_foto_perfil ?? null;
        $this->sexo = $data->sexo ?? null;
        $this->tipoSangre = $data->tipo_sangre ?? null;
        $this->tipoVivienda = $data->tipo_vivienda ?? null;
        // $this->validaciones = new SagrilaftEmpleadoRelUrlDTO($data->validaciones);
        $this->validaciones = $data->validaciones->map(fn($validaciones) =>  new SagrilaftEmpleadoRelUrlDTO($validaciones))->toArray();

        $this->academias = $data->academia->map(fn($academia) => new EmpleadoAcademicoDTO($academia->academia))->toArray();
        $this->experienciaLaboral = $data->experienciaLaboral->map(fn($experienciaLaboral) => new EmpleadoExperienciaLaboralDTO($experienciaLaboral->experiencia_laboral))->toArray();
        $this->familiares = $data->familiares->map(fn($familiares) => new EmpleadoFamiliaresDTO($familiares->familiares))->toArray();
        $this->personales = $data->personales->map(fn($personales) => new EmpleadoPersonalesDTO($personales->personales))->toArray();
        $this->complementarios = $data->complementarios->map(fn($complementarios) => new EmpleadoComplementarioDTO($complementarios->complementarios))->toArray();

        $this->createdAt = $data->created_at ?? null;
        $this->updatedAt = $data->updated_at ?? null;
    }
}
