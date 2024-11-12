<?php

namespace App\Data\Dtos\Empleados\Requests\RelacionesEmpleados;

class REmpleadoAcademiaCreateDTO
{
    public $empleadoId;
    public $academiaId;

    public function __construct($empleadoId, $academiaId)
    {
        $this->empleadoId = $empleadoId;
        $this->academiaId = $academiaId;
    }

    public function toArray()
    {
        return [
            'empleado_id' => $this->empleadoId,
            'academicos_id' => $this->academiaId
        ];
    }
}
