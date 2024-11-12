<?php

namespace App\Data\Dtos\Empleados\Responses\Empleado\Details;

class EmpleadoAcademicoDTO
{

    public ?string $academiaId;
    public ?string $institucion;
    public ?string $tituloObtenido;
    public ?string $fechaInicial;
    public ?string $fechaFinal;
    public ?string $ciudad;
    public ?string $createdAt;
    public ?string $updatedAt;

    public function __construct($academia)
    {
        $this->academiaId = $academia->id ?? null;
        $this->createdAt = $academia->created_at ?? null;
        $this->updatedAt = $academia->updated_at ?? null;
        $this->institucion = $academia->institucion ?? null;
        $this->tituloObtenido = $academia->titulo_obtenido ?? null;
        $this->fechaInicial = $academia->fecha_inicial ?? null;
        $this->fechaFinal = $academia->fecha_final ?? null;
        $this->ciudad = $academia->ciudad ?? null;
    }
}
