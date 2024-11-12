<?php

namespace App\Data\Dtos\Sagrilaft\Validacion\TiposValidacion\Response;

/**
 * Clase Data Transfer Object (DTO) para la respuesta de tipos de validación.
 *
 * Esta clase se utiliza para encapsular los datos de respuesta relacionados
 * con un tipo de validación en el sistema Sagrilaft. Proporciona un formato
 * estructurado para acceder a estos datos de manera coherente.
 */
class TipoValidacionDTO
{
    public $tipoValidacionId; // ID del tipo de validación
    public $nombre;           // Nombre del tipo de validación
    public $descripcion;      // Descripción del tipo de validación
    public $createdAt;        // Fecha de creación del tipo de validación
    public $updatedAt;        // Fecha de última actualización del tipo de validación

    /**
     * Constructor de la clase.
     *
     * @param object $tipoValidacion Objeto que contiene los datos del tipo de validación.
     */
    public function __construct($tipoValidacion)
    {
        $this->tipoValidacionId = $tipoValidacion->id ?? null;
        $this->nombre = $tipoValidacion->nombre ?? null;
        $this->descripcion = $tipoValidacion->descripcion ?? null;
        $this->createdAt = $tipoValidacion->created_at ?? null;
        $this->updatedAt = $tipoValidacion->updated_at ?? null;
    }
}
