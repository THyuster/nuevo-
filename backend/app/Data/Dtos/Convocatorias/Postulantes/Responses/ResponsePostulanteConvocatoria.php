<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\Responses;

use App\Data\Dtos\Contabilidad\Identificaciones\identificacionUserDTO;
use App\Data\Dtos\Contabilidad\Identificaciones\TipoIdentificacionDTO;
use App\Data\Dtos\Contabilidad\Localidades\Departamentos\DepartamentoDTO;
use App\Data\Dtos\Contabilidad\Localidades\Municipios\MunicipioDTO;
use App\Utils\MyFunctions;

/**
 * Clase para representar la respuesta de un postulante en una convocatoria.
 */
class ResponsePostulanteConvocatoria
{
    public ?string $nomina_convocatoria_postulante_id;
    public ?int $nomina_convocatoria_id;
    public ?string $nombre_completo;
    public identificacionUserDTO $identificacion;
    public ?string $nombre1;
    public ?string $nombre2;
    public ?string $apellido1;
    public ?string $apellido2;
    public ?string $fecha_nacimiento;
    public ?string $lugar_nacimiento;
    public ?int $edad;
    public ?string $email;
    public ?string $telefono;
    public ?string $direccion;
    public DepartamentoDTO $departamento;
    public ?string $estado_civil;
    public ?string $sexo;
    public ?string $tipo_sangre;
    public ?string $tipo_vivienda;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $estado;
    public array $postulante;
    public array $academias = [];
    public array $experiencia_laboral = [];
    public array $familiares = [];
    public array $personales = [];
    public array $complementarios = [];
    public ?string $ruta_foto_perfil;

    /**
     * Constructor para inicializar la respuesta del postulante.
     *
     * @param object $postulante Objeto con la información del postulante.
     */
    public function __construct($postulante)
    {
        // Inicializa el estado usando una función de utilidad
        $this->estado = MyFunctions::obtenerEstado($postulante->estado);

        // Asigna valores a las propiedades del objeto
        $this->nomina_convocatoria_postulante_id = $postulante->nomina_convocatoria_postulante_id ?? null;
        $this->nomina_convocatoria_id = $postulante->nomina_convocatoria_id ?? null;

        // Inicializa el objeto de identificación
        $identificacionDTO = new TipoIdentificacionDTO($postulante->tipo_identificaciones);
        $this->identificacion = new identificacionUserDTO(
            $postulante->tipo_identificacion,
            "$identificacionDTO->codigo ($identificacionDTO->descripcion)",
            $postulante->identificacion
        ) ?? null;

        // Asigna valores a los atributos personales
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

        // Inicializa el objeto DepartamentoDTO y MunicipioDTO
        $this->departamento = new DepartamentoDTO($postulante->departamentos) ?? null;
        $this->departamento->municipio = new MunicipioDTO($postulante->municipios);

        // Asigna valores para estado civil, sexo, tipo de sangre y vivienda
        $this->estado_civil = $postulante->estado_civil ?? null;
        // $this->ruta_foto_perfil = $postulante->ruta_foto_perfil ?? null;
        $this->sexo = MyFunctions::toStringSexo($postulante->sexo) ?? null;
        $this->tipo_sangre = $postulante->tipo_sangre ?? null;
        $this->tipo_vivienda = $postulante->tipo_vivienda ?? null;
        $this->created_at = $postulante->created_at ?? null;
        $this->updated_at = $postulante->updated_at ?? null;

        // Calcula el nombre completo usando una función de utilidad
        $this->nombre_completo = MyFunctions::concatenarYLimpiar([
            $postulante->nombre1 ?? null,
            $postulante->nombre2 ?? null,
            $postulante->apellido1 ?? null,
            $postulante->apellido2 ?? null
        ]) ?? null;

        // Usa el método `map` para trabajar con colecciones Eloquent
        $this->academias = $postulante->academia->map(fn($academia) => $academia->academia)->toArray();
        $this->experiencia_laboral = $postulante->experiencia_laboral->map(fn($experienciaLaboral) => $experienciaLaboral->experiencia_laboral)->toArray();
        $this->familiares = $postulante->familiares->map(fn($familiares) => $familiares->familiares)->toArray();
        $this->personales = $postulante->personales->map(fn($personales) => $personales->personales)->toArray();
        $this->complementarios = $postulante->complementarios->map(fn($complementarios) => $complementarios->complementarios)->toArray();
    }
}
