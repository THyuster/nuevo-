<?php

namespace App\Data\Dtos\Convocatorias\Postulantes;

use App\Utils\MyFunctions;

class PostulanteRequestDTO
{
    public string $nominaConvocatoriaPostulanteId;
    public ?string $nominaConvocatoriaId;
    public ?string $tipoIdentificacion;
    public ?string $identificacion;
    public ?string $nombre1;
    public ?string $nombre2;
    public ?string $apellido1;
    public ?string $apellido2;
    public ?string $fechaNacimiento;
    public ?string $lugarNacimiento;
    public ?int $edad;
    public ?string $email;
    public ?string $telefono;
    public ?string $direccion;
    public ?string $departamento;
    public ?string $municipio;
    public ?string $estadoCivil;
    public ?string $rutaFotoPerfil;
    public ?string $sexo;
    public ?string $tipoSangre;
    public ?string $tipoVivienda;
    /**
     * @var array<PostulanteCreateComplementariosDTO>
     */
    public array $postulanteComplementario;
     /**
     * @var array<PostulanteCreateAcademicaDTO>
     */
    public array $postulanteAcademia;
    /**
     * @var array<PostulanteCreateExperienciaLaboralDTO>
     */
    public array $postulanteExperienciaLaboral;
    /**
     * @var array<PostulanteCreateRelacionPersonalDTO>
     */
    public array $postulanteRelacionesPersonales;
    /**
     * @var array<PostulanteCreateRelacionFamiliaresDTO>
     */
    public array $postulanteRelacionFamiliares;

    public function __construct(array $data)
    {
        $this->nominaConvocatoriaPostulanteId = uuid_create();
        $this->nominaConvocatoriaId = $data['nomina_convocatoria_id'] ?? null;
        $this->tipoIdentificacion = $data['tipo_identificacion'] ?? null;
        $this->identificacion = $data['identificacion'] ?? null;
        $this->nombre1 = $data['nombre1'] ?? null;
        $this->nombre2 = $data['nombre2'] ?? null;
        $this->apellido1 = $data['apellido1'] ?? null;
        $this->apellido2 = $data['apellido2'] ?? null;
        $this->fechaNacimiento = $data['fecha_nacimiento'] ?? null;
        $this->lugarNacimiento = $data['lugar_nacimiento'] ?? null;
        $this->edad = MyFunctions::calcularEdad($this->fechaNacimiento) ?? null;
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

        // Initialize arrays with converted DTOs
        $this->postulanteComplementario = $this->convertToDTOArray(
            $data['complementarios'] ?? [],
            PostulanteCreateComplementariosDTO::class
        );
        $this->postulanteAcademia = $this->convertToDTOArray(
            $data['academias'] ?? [],
            PostulanteCreateAcademicaDTO::class
        );
        $this->postulanteExperienciaLaboral = $this->convertToDTOArray(
            $data['experiencias_laborales'] ?? [],
            PostulanteCreateExperienciaLaboralDTO::class
        );
        $this->postulanteRelacionesPersonales = $this->convertToDTOArray(
            $data['relaciones_personales'] ?? [],
            PostulanteCreateRelacionPersonalDTO::class
        );
        $this->postulanteRelacionFamiliares = $this->convertToDTOArray(
            $data['relaciones_familiares'] ?? [],
            PostulanteCreateRelacionFamiliaresDTO::class
        );
    }

    /**
     * Convierte una lista de datos en un array de DTOs.
     *
     * @param array $data Lista de datos a convertir.
     * @param string $dtoClass Nombre de la clase del DTO a usar.
     * @return array Array de datos de DTOs.
     */
    private function convertToDTOArray(array $data, string $dtoClass): array
    {
        return array_map(
            fn($item) => (new $dtoClass($item))->toArray(),
            $data
        );
    }

    /**
     * Convierte el objeto en un array asociativo.
     *
     * @return array Array representativo del objeto.
     */
    public function toArray(): array
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
            'tipo_sangre' => $this->tipoSangre,
            'tipo_vivienda' => $this->tipoVivienda,
            'complementarios' => $this->postulanteComplementario,
            'academias' => $this->postulanteAcademia,
            'experiencias_laborales' => $this->postulanteExperienciaLaboral,
            'relaciones_personales' => $this->postulanteRelacionesPersonales,
            'relaciones_familiares' => $this->postulanteRelacionFamiliares,
        ];
    }
}
