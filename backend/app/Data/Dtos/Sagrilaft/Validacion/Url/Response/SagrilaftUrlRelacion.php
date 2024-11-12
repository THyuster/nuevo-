<?php

namespace App\Data\Dtos\Sagrilaft\Validacion\Url\Response;

/**
 * Clase que representa la relación de una URL dentro del sistema Sagrilaft.
 *
 * Esta clase encapsula la información de cada relación de URL,
 * incluyendo si es principal y las fechas de creación y actualización.
 */
class SagrilaftUrlRelacion
{
    public $sagrilafUrlRelId; // ID de la relación de la URL
    public $url;              // La URL en sí
    public $principal;        // Indica si la URL es principal
    public $createdAt;        // Fecha de creación
    public $updatedAt;        // Fecha de actualización

    /**
     * Constructor de la clase SagrilaftUrlRelacion.
     *
     * @param object $sagrilaftUrlRel Objeto que contiene los datos de la relación de la URL.
     */
    public function __construct($sagrilaftUrlRel)
    {
        $this->sagrilafUrlRelId = $sagrilaftUrlRel->id ?? null; // Asigna el ID de la relación
        $this->url = $sagrilaftUrlRel->url ?? null; // Asigna la URL
        $this->principal = boolval($sagrilaftUrlRel->principal) ?? null; // Asigna si es principal
        $this->createdAt = $sagrilaftUrlRel->created_at ?? null; // Asigna la fecha de creación
        $this->updatedAt = $sagrilaftUrlRel->updated_at ?? null; // Asigna la fecha de actualización
    }
}
