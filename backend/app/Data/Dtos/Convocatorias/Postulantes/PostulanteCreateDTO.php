<?php

namespace App\Data\Dtos\Convocatorias\Postulantes;

class PostulanteCreateDTO
{
    public string $nominaConvocatoriaPostulanteId;
    public $nominaConvocatoriaId;
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
    // public $vehiculoPropio;
    public $tipoSangre;
    public $tipoVivienda;

    public function __construct(PostulanteRequestDTO $postulanteRequestDTO)
    {
        $this->nominaConvocatoriaPostulanteId = $postulanteRequestDTO->nominaConvocatoriaPostulanteId;
        $this->nominaConvocatoriaId = $postulanteRequestDTO->nominaConvocatoriaId;
        $this->tipoIdentificacion = $postulanteRequestDTO->tipoIdentificacion;
        $this->identificacion = $postulanteRequestDTO->identificacion;
        $this->nombre1 = $postulanteRequestDTO->nombre1;
        $this->nombre2 = $postulanteRequestDTO->nombre2;
        $this->apellido1 = $postulanteRequestDTO->apellido1;
        $this->apellido2 = $postulanteRequestDTO->apellido2;
        $this->fechaNacimiento = $postulanteRequestDTO->fechaNacimiento;
        $this->lugarNacimiento = $postulanteRequestDTO->lugarNacimiento;
        $this->edad = $postulanteRequestDTO->edad;
        $this->email = $postulanteRequestDTO->email;
        $this->telefono = $postulanteRequestDTO->telefono;
        $this->direccion = $postulanteRequestDTO->direccion;
        $this->departamento = $postulanteRequestDTO->departamento;
        $this->municipio = $postulanteRequestDTO->municipio;
        $this->estadoCivil = $postulanteRequestDTO->estadoCivil;
        $this->rutaFotoPerfil = $postulanteRequestDTO->rutaFotoPerfil;
        $this->sexo = $postulanteRequestDTO->sexo;
        $this->tipoSangre = $postulanteRequestDTO->tipoSangre;
        $this->tipoVivienda = $postulanteRequestDTO->tipoVivienda;
    }

    public function toArray()
    {
        return [
            'nomina_convocatoria_postulante_id' => $this->nominaConvocatoriaPostulanteId,
            'nomina_convocatoria_id' => $this->nominaConvocatoriaId,
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
            // 'vehiculo_propio' => $this->vehiculoPropio,
            'tipo_sangre' => $this->tipoSangre,
            'tipo_vivienda' => $this->tipoVivienda,
        ];
    }
}
