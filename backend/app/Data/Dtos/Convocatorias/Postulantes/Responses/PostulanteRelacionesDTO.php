<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\Responses;

class PostulanteRelacionesDTO
{
    public $nomina_convocatoria_postulante_id;
    public $nomina_convocatoria_id;
    public $nombre_completo;
    public $tipo_identificacion;
    public $identificacion;
    public $nombre1;
    public $nombre2;
    public $apellido1;
    public $apellido2;
    public $fecha_nacimiento;
    public $lugar_nacimiento;
    public $edad;
    public $email;
    public $telefono;
    public $direccion;
    public $departamento;
    public $municipio;
    public $estado_civil;
    public $ruta_foto_perfil;
    public $sexo;
    public $tipo_sangre;
    public $tipo_vivienda;
    public $created_at;
    public $updated_at;
    public $estado;
    // public  $postulante;
    public array $academias = [];
    public array $experiencia_laboral = [];
    public array $familiares = [];
    public array $personales = [];
    public array $complementarios = [];

    public function __construct($postulante)
    {
        $this->nomina_convocatoria_postulante_id = $postulante->nomina_convocatoria_postulante_id ?? null;
        $this->nomina_convocatoria_id = $postulante->nomina_convocatoria_id ?? null;
        $this->tipo_identificacion = $postulante->tipo_identificacion ?? null;
        $this->identificacion = $postulante->identificacion ?? null;
        $this->nombre1 = $postulante->nombre1 ?? null;
        $this->nombre2 = $postulante->nombre2 ?? null;
        $this->apellido1 = $postulante->apellido1 ?? null;
        $this->apellido2 = $postulante->apellido2 ?? null;
        $this->fecha_nacimiento = $postulante->fecha_nacimiento ?? null;
        $this->lugar_nacimiento = $postulante->lugar_nacimiento ?? null;
        $this->edad = $postulante->edad ?? null;
        $this->email = $postulante->email ?? null;
        $this->telefono = $postulante->telefono ?? null;
        $this->direccion = $postulante->direccion ?? null;
        $this->departamento = $postulante->departamento ?? null;
        $this->municipio = $postulante->municipio ?? null;
        $this->estado_civil = $postulante->estado_civil ?? null;
        $this->ruta_foto_perfil = $postulante->ruta_foto_perfil ?? null;
        $this->sexo = $postulante->sexo ?? null;
        $this->tipo_sangre = $postulante->tipo_sangre ?? null;
        $this->tipo_vivienda = $postulante->tipo_vivienda ?? null;
        $this->created_at = $postulante->created_at ?? null;
        $this->updated_at = $postulante->updated_at ?? null;
        // $this->
        $this->nombre_completo = trim(implode(' ', array_filter([
            $postulante->nombre1 ?? null,
            $postulante->nombre2 ?? null,
            $postulante->apellido1 ?? null,
            $postulante->apellido2 ?? null
        ]))) ?? null;
        
        $this->academias = $postulante->academia->map(fn($academia) => $academia->academia)->toArray();
        $this->experiencia_laboral = $postulante->experiencia_laboral->map(fn($experienciaLaboral) => $experienciaLaboral->experiencia_laboral)->toArray();
        $this->familiares = $postulante->familiares->map(fn($familiares) => $familiares->familiares)->toArray();
        $this->personales = $postulante->personales->map(fn($personales) => $personales->personales)->toArray();
        $this->complementarios = $postulante->complementarios->map(fn($complementarios) => $complementarios->complementarios)->toArray();

    }
}
