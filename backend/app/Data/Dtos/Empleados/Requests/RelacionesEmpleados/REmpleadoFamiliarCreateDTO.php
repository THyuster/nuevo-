<?php

namespace App\Data\Dtos\Empleados\Requests\RelacionesEmpleados;

class REmpleadoFamiliarCreateDTO
{
    public $empleadoId;
    public $familiaresId;

    public function __construct($empleadoId, $familiaresId)
    {
        $this->empleadoId = $empleadoId;
        $this->familiaresId = $familiaresId;
    }

    public function toArray()
    {
        return [
            'empleado_id' => $this->empleadoId,
            'familiares_id' => $this->familiaresId
        ];
    }
}
