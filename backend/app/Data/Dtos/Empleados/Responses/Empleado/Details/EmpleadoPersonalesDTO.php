<?php

namespace App\Data\Dtos\Empleados\Responses\Empleado\Details;

class EmpleadoPersonalesDTO
{
    public ?string $personalId;
    public ?string $nombreCompleto;
    public ?string $telefono;
    public ?string $direccion;
    public ?string $relacion;
    public ?string $cedula;
    public ?string $createdAt;
    public ?string $updatedAt;

    public function __construct($familiares = null)
    {
        $this->personalId = $familiares->id ?? null;
        $this->createdAt = $familiares->created_at ?? null;
        $this->updatedAt = $familiares->updated_at ?? null;
        $this->nombreCompleto = $familiares->nombre_completo ?? null;
        $this->telefono = $familiares->telefono ?? null;
        $this->direccion = $familiares->direccion ?? null;
        $this->relacion = $familiares->relacion ?? null;
        $this->cedula = $familiares->cedula ?? null;
    }
}
