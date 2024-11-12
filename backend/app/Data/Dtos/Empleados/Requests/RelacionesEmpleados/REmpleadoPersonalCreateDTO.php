<?php

namespace App\Data\Dtos\Empleados\Requests\RelacionesEmpleados;

class REmpleadoPersonalCreateDTO
{
    public $empleadoId;
    public $pesonalesId;

    public function __construct($empleadoId, $pesonalesId)
    {
        $this->empleadoId = $empleadoId;
        $this->pesonalesId = $pesonalesId;
    }

    public function toArray()
    {
        return [
            'empleado_id' => $this->empleadoId,
            'personales_id' => $this->pesonalesId
        ];
    }
}

