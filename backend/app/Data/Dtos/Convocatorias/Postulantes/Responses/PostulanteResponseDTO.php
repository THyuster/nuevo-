<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\Responses;
use App\Utils\MyFunctions;

class PostulanteResponseDTO
{
    public $nominaConvocatoriaPostulanteId;
    public $nominaConvocatoriaId;
    public $tipoIdentificacion;
    public  $identificacion;
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
    public $sexo;
    public $tipoSangre;
    public $tipoVivienda;
    public $createdAt;
    public $updatedAt;
    public $nombreCompleto;
    public $rutaFotoPerfil;
    public $academias = [];
    public $experiencia_laboral = [];
    public $familiares = [];
    public $personales = [];
    public $complementarios = [];

    public function __construct($postulanteRequestDTO)
    {
        $this->nominaConvocatoriaPostulanteId = $postulanteRequestDTO->nomina_convocatoria_postulante_id ?? null;
        $this->nominaConvocatoriaId = $postulanteRequestDTO->nomina_convocatoria_id ?? null;
        $this->tipoIdentificacion = $postulanteRequestDTO->tipo_identificacion ?? null;
        $this->identificacion = $postulanteRequestDTO->identificacion ?? null;
        $this->nombre1 = $postulanteRequestDTO->nombre1 ?? null;
        $this->nombre2 = $postulanteRequestDTO->nombre2 ?? null;
        $this->apellido1 = $postulanteRequestDTO->apellido1 ?? null;
        $this->apellido2 = $postulanteRequestDTO->apellido2 ?? null;
        $this->fechaNacimiento = $postulanteRequestDTO->fecha_nacimiento ?? null;
        $this->lugarNacimiento = $postulanteRequestDTO->lugar_nacimiento ?? null;
        $this->edad = $postulanteRequestDTO->edad ?? null;
        $this->email = $postulanteRequestDTO->email ?? null;
        $this->telefono = $postulanteRequestDTO->telefono ?? null;
        $this->direccion = $postulanteRequestDTO->direccion ?? null;
        $this->departamento = $postulanteRequestDTO->departamento ?? null;
        $this->municipio = $postulanteRequestDTO->municipio ?? null;
        $this->estadoCivil = $postulanteRequestDTO->estado_civil ?? null;
        $this->rutaFotoPerfil = $postulanteRequestDTO->ruta_foto_perfil ?? null;
        $this->sexo = $postulanteRequestDTO->sexo ?? null;
        // $this->vehiculoPropio = $postulanteRequestDTO->vehiculoPropio ?? null;
        $this->tipoSangre = $postulanteRequestDTO->tipo_sangre ?? null;
        $this->tipoVivienda = $postulanteRequestDTO->tipo_vivienda ?? null;
        $this->createdAt = $postulanteRequestDTO->created_at ?? null;
        $this->updatedAt = $postulanteRequestDTO->updated_at ?? null;
        $this->nombreCompleto = trim(implode(' ', array_filter([
            $postulanteRequestDTO->nombre1 ?? null,
            $postulanteRequestDTO->nombre2 ?? null,
            $postulanteRequestDTO->apellido1 ?? null,
            $postulanteRequestDTO->apellido2 ?? null
        ]))) ?? null;
        $this->academias = $postulanteRequestDTO->academias ?? [];
        $this->experiencia_laboral = $postulanteRequestDTO->experiencia_laboral ?? [];
        $this->familiares = $postulanteRequestDTO->familiares ?? [];
        $this->personales = $postulanteRequestDTO->personales ?? [];
        $this->complementarios = $postulanteRequestDTO->complementarios ?? [];
    }

    public function toArray(): array
    {
        return [
            'nomina_convocatoria_postulante_id' => $this->nominaConvocatoriaPostulanteId ?? null,
            'nomina_convocatoria_id' => $this->nominaConvocatoriaId ?? null,
            'tipo_identificacion' => $this->tipoIdentificacion ?? null,
            'identificacion' => $this->identificacion ?? null,
            'nombre1' => $this->nombre1 ?? null,
            'nombre2' => $this->nombre2 ?? null,
            'apellido1' => $this->apellido1 ?? null,
            'apellido2' => $this->apellido2 ?? null,
            'fecha_nacimiento' => $this->fechaNacimiento ?? null,
            'lugar_nacimiento' => $this->lugarNacimiento ?? null,
            'edad' => $this->edad ?? null,
            'email' => $this->email ?? null,
            'telefono' => $this->telefono ?? null,
            'direccion' => $this->direccion ?? null,
            'departamento' => $this->departamento ?? null,
            'municipio' => $this->municipio ?? null,
            'estado_civil' => $this->estadoCivil ?? null,
            'sexo' => MyFunctions::toStringSexo($this->sexo) ?? null,
            "nombreCompleto" => $this->nombreCompleto ?? null,
            'tipo_sangre' => $this->tipoSangre ?? null,
            'tipo_vivienda' => $this->tipoVivienda ?? null,
            'created_at' => $this->createdAt ?? null,
            'updated_at' => $this->updatedAt ?? null,
            'academias' => $this->academias ?? null,
            'experiencia_laboral' => $this->experiencia_laboral ?? null,
            'familiares' => $this->familiares ?? null,
            'personales' => $this->personales ?? null,
            'complementarios' => $this->complementarios ?? null,
            // 'ruta_foto_perfil' => $this->rutaFotoPerfil ?? null,
        ];
    }
}
