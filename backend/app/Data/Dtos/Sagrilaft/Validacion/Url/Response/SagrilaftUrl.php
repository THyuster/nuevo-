<?php

namespace App\Data\Dtos\Sagrilaft\Validacion\Url\Response;
use App\Data\Dtos\Sagrilaft\Validacion\TiposValidacion\Response\TipoValidacionDTO;

/**
 * Clase que representa una URL dentro del sistema Sagrilaft.
 *
 * Esta clase encapsula la información relacionada con una URL,
 * incluyendo su estado, descripción, y las validaciones asociadas.
 */
class SagrilaftUrl
{
    public $sagrilafUrlId;      // ID de la URL en Sagrilaft
    public $descripcion;         // Descripción de la URL
    /**
     * @var array<SagrilaftUrlRelacion> Colección de relaciones de URLs.
     */
    public array $urls = [];     // Arreglo de objetos de relaciones de URLs
    /**
     * @var array<TipoValidacionDTO> Colección de tipo validaciones.
     */
    public array $tiposValidacion = []; // Arreglo de tipos de validación asociados
    public $createdAt;           // Fecha de creación
    public $updatedAt;           // Fecha de actualización

    /**
     * Constructor de la clase SagrilaftUrl.
     *
     * @param object $sagrilaftUrls Objeto que contiene los datos de la URL.
     */
    public function __construct($sagrilaftUrls)
    {
        $this->sagrilafUrlId = $sagrilaftUrls->id ?? null; // Asigna el ID de la URL
        foreach ($sagrilaftUrls->urls ?? [] as $sagrilaftUrlRel) {
            $this->urls[] = new SagrilaftUrlRelacion($sagrilaftUrlRel); // Crea relaciones de URL
        }
        foreach ($sagrilaftUrls->tipoValidaciones->sagrilaftValidaciones ?? [] as $validacion) {
            $this->tiposValidacion[] = new TipoValidacionDTO($validacion); // Crea tipos de validación
        }
        $this->descripcion = $sagrilaftUrls->descripcion ?? null; // Asigna la descripción
        $this->createdAt = $sagrilaftUrls->created_at ?? null; // Asigna la fecha de creación
        $this->updatedAt = $sagrilaftUrls->updated_at ?? null; // Asigna la fecha de actualización
    }

}
