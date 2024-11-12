<?php

namespace App\Data\Dtos\Empleados\Responses\Empleado\Details;

class EmpleadoComplementarioDTO
{

    public ?string $complementarioId;

    public ?string $aspiracionIngresos;
    public ?int $licenciasConduccion;
    public ?string $nivelIngles;
    public ?string $habilidadesInformaticas;
    public ?bool $inmediatezInicial;
    public ?string $paisesVisitados;
    public ?string $estatura;
    public ?string $peso;
    public ?int $deporte;
    public ?bool $fuma;
    public ?bool $alcohol;
    public ?bool $vehiculoPropio;
    public ?string $tipoVehiculo;
    public ?string $createdAt;
    public ?string $updatedAt;

    public function __construct($complementario = null)
    {
        $this->complementarioId = $complementario->id ?? null;
        $this->createdAt = $complementario->created_at ?? null;
        $this->updatedAt = $complementario->updated_at ?? null;
        $this->aspiracionIngresos = $complementario->aspiracion_ingresos ?? null;
        $this->licenciasConduccion = $complementario->licencias_conduccion ?? null;
        $this->nivelIngles = $complementario->nivel_ingles ?? null;
        $this->habilidadesInformaticas = $complementario->habilidades_informaticas ?? null;
        $this->inmediatezInicial = $complementario->inmediatez_inicial ?? null;
        $this->paisesVisitados = $complementario->paises_visitados ?? null;
        $this->estatura = $complementario->estatura ?? null;
        $this->peso = $complementario->peso ?? null;
        $this->deporte = $complementario->deporte ?? null;
        $this->fuma = $complementario->fuma ?? null;
        $this->alcohol = $complementario->alcohol ?? null;
        $this->vehiculoPropio = $complementario->vehiculo_propio ?? null;
        $this->tipoVehiculo = $complementario->tipo_vehiculo ?? null;
    }
}
