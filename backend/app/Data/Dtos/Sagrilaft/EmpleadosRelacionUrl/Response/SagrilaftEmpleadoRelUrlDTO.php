<?php

namespace App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Response;
use App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request\SagrilaftValidacionEmpleadosRecursosDTO;

/**
 * Clase Data Transfer Object (DTO) para la respuesta de relaciones de URL de empleados.
 *
 * Esta clase se utiliza para encapsular los datos de respuesta relacionados
 * con la relación entre un empleado y una URL en el sistema Sagrilaft. 
 * Proporciona un formato estructurado para acceder a estos datos.
 */
class SagrilaftEmpleadoRelUrlDTO
{
    public $empleadoRelUrlId; // ID de la relación de URL del empleado
    public $empleadoId;        // ID del empleado
    public $sagrilaftUrlId;    // ID de la URL en Sagrilaft
    public $descripcion;       // Descripción de la relación
    public $color;             // Color asociado a la relación
    public $estado;            // Estado de la relación
    public array $resources = [];

    public $createdAt;         // Fecha de creación de la relación
    public $updatedAt;         // Fecha de última actualización de la relación
    /**
     * Constructor de la clase.
     *
     * @param object $sagrilaftEmpleadosRelUrl Objeto que contiene los datos de la relación.
     */
    public function __construct($sagrilaftEmpleadosRelUrl)
    {
        $this->empleadoRelUrlId = $sagrilaftEmpleadosRelUrl->id ?? null;
        $this->empleadoId = $sagrilaftEmpleadosRelUrl->empleado_id ?? null;
        $this->sagrilaftUrlId = $sagrilaftEmpleadosRelUrl->url_id ?? null;
        $this->descripcion = $sagrilaftEmpleadosRelUrl->descripcion ?? null;
        $this->color = $sagrilaftEmpleadosRelUrl->color ?? null;

        foreach ($sagrilaftEmpleadosRelUrl->resources ?? [] as $resource) {
            # code...
            $this->resources[] = new SagrilaftValidacionEmpleadosRecursosDTO($resource);
        }

        $this->estado = isset($sagrilaftEmpleadosRelUrl->estado) ? (bool)$sagrilaftEmpleadosRelUrl->estado : null;
        $this->createdAt = $sagrilaftEmpleadosRelUrl->created_at ?? null;
        $this->updatedAt = $sagrilaftEmpleadosRelUrl->updated_at ?? null;
    }
}
