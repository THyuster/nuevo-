<?php

namespace App\Data\Dtos\Empleados\Responses\Empleado\Details;

class EmpleadoExperienciaLaboralDTO
{
    public string|null $experienciaLaboralId;
    public string|null $empresa;
    public string|null $cargo;
    public string|null $jefe;
    public string|null $telefono;
    public string|null $fechaInicio;
    public string|null $fechaFin;
    public string|null $responsabilidad;
    public string|null $createdAt;
    public string|null $updatedAt;


    public function __construct($experienciaLaboral = null)
    {
        $this->experienciaLaboralId = $experienciaLaboral->id ?? null;
        $this->empresa = $experienciaLaboral->empresa ?? null;
        $this->cargo = $experienciaLaboral->cargo ?? null;
        $this->jefe = $experienciaLaboral->jefe ?? null;
        $this->telefono = $experienciaLaboral->telefono ?? null;
        $this->fechaInicio = $experienciaLaboral->fecha_inicio ?? null;
        $this->fechaFin = $experienciaLaboral->fecha_fin ?? null;
        $this->responsabilidad = $experienciaLaboral->responsabilidades ?? null;
        $this->createdAt = $experienciaLaboral->created_at ?? null;
        $this->updatedAt = $experienciaLaboral->updated_at ?? null;
    }
}
