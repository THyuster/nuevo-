<?php

namespace App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request;

/**
 * Class SagrilaftValidacionEmpleadosRecursosDTO
 *
 * Esta clase representa un DTO (Data Transfer Object) para almacenar
 * la información relacionada con los recursos de validación de empleados.
 *
 * @package App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request
 */
class SagrilaftValidacionEmpleadosRecursosDTO
{
    /**
     * @var string|null Ruta del recurso (archivo o imagen).
     */
    public $path;

    /**
     * @var string|null ID de la relación del empleado con la URL.
     */
    public $empleadoRelURLId;

    /**
     * SagrilaftValidacionEmpleadosRecursos constructor.
     *
     * @param mixed|null $validacionEmpleadoRecurso Objeto que contiene los datos de validación de recursos.
     */
    public function __construct($validacionEmpleadoRecurso = null)
    {
        $this->path = $validacionEmpleadoRecurso->path ?? null;
        $this->empleadoRelURLId = $validacionEmpleadoRecurso->empleado_rel_url_id ?? null;
    }

    /**
     * Convierte el objeto a un array.
     *
     * @return array Arreglo que representa los atributos del objeto.
     */
    public function toArray()
    {
        return [
            "path" => $this->path,
            "empleado_rel_url_id" => $this->empleadoRelURLId,
        ];
    }
}
