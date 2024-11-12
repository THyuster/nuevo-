<?php

namespace App\Data\Dtos\Empleados\Responses\Empleado\Details;

class EmpleadoFamiliaresDTO
{
    public ?string $familiarId;
    public ?string $nombreCompleto;
    public ?string $telefono;
    public ?string $direccion;
    public ?string $parentesco;
    public ?string $cedula;
    public ?string $createdAt;
    public ?string $updatedAt;

    public function __construct($familiares = null)
    {
        $this->familiarId = $familiares->id ?? null;
        $this->createdAt = $familiares->created_at ?? null;
        $this->updatedAt = $familiares->updated_at ?? null;
        $this->nombreCompleto = $familiares->nombre_completo ?? null;
        $this->telefono = $familiares->telefono ?? null;
        $this->direccion = $familiares->direccion ?? null;
        $this->parentesco = $familiares->parentesco ?? null;
        $this->cedula = $familiares->cedula ?? null;
    }
}
