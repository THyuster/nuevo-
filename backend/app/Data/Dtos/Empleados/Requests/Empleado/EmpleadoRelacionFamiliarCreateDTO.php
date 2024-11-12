<?php

namespace App\Data\Dtos\Empleados\Requests\Empleado;

class EmpleadoRelacionFamiliarCreateDTO
{
    public $id;
    public $nombreCompleto;
    public $telefono;
    public $parentesco;
    public $direccion;

    public function __construct(array $data)
    {
        $this->nombreCompleto = $data['nombre_completo'] ?? null;
        $this->telefono = $data['telefono'] ?? null;
        $this->parentesco = $data['parentesco'] ?? null;
        $this->direccion = $data['direccion'] ?? null;
        $this->id = $data['id'] ?? uuid_create();
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "nombre_completo" => $this->nombreCompleto,
            "telefono" => $this->telefono,
            "parentesco" => $this->parentesco,
            "direccion" => $this->direccion,
        ];
    }
}
