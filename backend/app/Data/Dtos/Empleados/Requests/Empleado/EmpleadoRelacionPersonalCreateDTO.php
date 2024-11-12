<?php

namespace App\Data\Dtos\Empleados\Requests\Empleado;

class EmpleadoRelacionPersonalCreateDTO
{
    public $id;
    public $nombreCompleto;
    public $telefono;
    public $relacion;
    public $direccion;

    public function __construct(array $data)
    {
        $this->nombreCompleto = $data['nombre_completo'];
        $this->telefono = $data['telefono'];
        $this->relacion = $data['relacion'];
        $this->direccion = $data['direccion'];
        $this->id = $data['id'] ?? uuid_create();
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "nombre_completo" => $this->nombreCompleto,
            "telefono" => $this->telefono,
            "relacion" => $this->relacion,
            "direccion" => $this->direccion,
        ];
    }
}
