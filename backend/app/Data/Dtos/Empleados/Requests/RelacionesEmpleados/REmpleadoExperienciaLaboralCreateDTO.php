<?php

namespace App\Data\Dtos\Empleados\Requests\RelacionesEmpleados;

class REmpleadoExperienciaLaboralCreateDTO
{
    public $empleadoId;
    public $laborales_id;

    public function __construct($empleadoId, $laborales_id)
    {
        $this->empleadoId = $empleadoId; 
        $this->laborales_id = $laborales_id;
    }

    public function toArray()
    {
        return [
            'empleado_id' => $this->empleadoId,
            'laborales_id' => $this->laborales_id
        ];
    }
}
