<?php

namespace App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Response;

class SagrilaftEmpleadoRecursosDTO
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
        $this->empleadoRelURLId = url($validacionEmpleadoRecurso->empleado_rel_url_id) ?? null;
    }
}
