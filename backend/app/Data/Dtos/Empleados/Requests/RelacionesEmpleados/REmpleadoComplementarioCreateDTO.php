<?php

namespace App\Data\Dtos\Empleados\Requests\RelacionesEmpleados;

class REmpleadoComplementarioCreateDTO
{
    public $empleadoId;
    public $complementariosId;

    public function __construct($empleadoId, $complementariosId)
    {
        $this->empleadoId = $empleadoId;
        $this->complementariosId = $complementariosId;
    }

    public function toArray()
    {
        return [
            'empleado_id' => $this->empleadoId,
            'complementarios_id' => $this->complementariosId
        ];
    }
}
