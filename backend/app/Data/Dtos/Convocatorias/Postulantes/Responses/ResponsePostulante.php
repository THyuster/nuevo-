<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\Responses;

use App\Data\Dtos\Convocatorias\Postulantes\Responses\Convocatorias\ConvocatoriaResponse;
// use App\Data\Dtos\Convocatorias\Postulantes\PostulanteResponseDTO;
use App\Utils\MyFunctions;

/**
 * Clase para representar la respuesta de un postulante en una convocatoria.
 */
class ResponsePostulante
{
    public int $id;
    public string $fecha_postulacion;
    public string $estado;
    public string $nombreConvocatoria;
    public array $postulante;

    /**
     * Constructor para inicializar la respuesta del postulante.
     *
     * @param object $postulante Objeto con la información del postulante.
     */
    public function __construct($postulante)
    {
        // Inicializa la información de la convocatoria
        $convocatoria = new ConvocatoriaResponse($postulante->convocatoria);

        // Inicializa el DTO del postulante
        $postulanteResponseDTO = new PostulanteResponseDTO($postulante->postulante);

        // Asigna valores a las propiedades del objeto
        $this->id = $postulante->id;
        $this->fecha_postulacion = $postulante->fecha_postulacion;
        $this->estado = MyFunctions::obtenerEstado($postulante->estado);
        $this->nombreConvocatoria = $convocatoria->nombre;

        // Asigna datos al DTO del postulante usando el mapeo de colecciones
        $postulanteResponseDTO->academias = $postulante->academia->map(fn($academia) => $academia->academia)->toArray();
        $postulanteResponseDTO->experiencia_laboral = $postulante->experiencia_laboral->map(fn($experienciaLaboral) => $experienciaLaboral->experiencia_laboral)->toArray();
        $postulanteResponseDTO->familiares = $postulante->familiares->map(fn($familiares) => $familiares->familiares)->toArray();
        $postulanteResponseDTO->personales = $postulante->personales->map(fn($personales) => $personales->personales)->toArray();
        $postulanteResponseDTO->complementarios = $postulante->complementarios->map(fn($complementarios) => $complementarios->complementarios)->toArray();

        // Asigna el DTO del postulante convertido a un array
        $this->postulante = $postulanteResponseDTO->toArray();
    } 
}
