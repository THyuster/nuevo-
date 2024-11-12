<?php

namespace App\Data\Dtos\Convocatorias;

class ConvocatoriasCreateDTO
{
    public $fecha_apertura;
    public $fecha_cierre;
    public $nomina_cargo_id;
    public $numero_puestos;
    public $nomina_solicitudes_empleo_id;

    public function __construct($fecha_apertura, $fecha_cierre, $nomina_cargo_id, $numero_puestos,$nomina_solicitudes_empleo_id )
    {
        $this->fecha_apertura = $fecha_apertura;
        $this->fecha_cierre = $fecha_cierre;
        $this->nomina_cargo_id = $nomina_cargo_id;
        $this->numero_puestos = $numero_puestos;
        $this->nomina_solicitudes_empleo_id = $nomina_solicitudes_empleo_id ;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['fecha_apertura'] ?? null,
            $data['fecha_cierre'] ?? null,
            $data['nomina_cargo_id'] ?? null,
            $data['numero_puestos'] ?? null,
            $data['nomina_solicitudes_empleo_id'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'fecha_apertura' => $this->fecha_apertura,
            'nomina_cargo_id' => $this->nomina_cargo_id,
            'fecha_cierre' => $this->fecha_cierre,
            'numero_puestos' => $this->numero_puestos,
            'nomina_solicitudes_empleo_id' => $this->nomina_solicitudes_empleo_id
        ];
    }

}

