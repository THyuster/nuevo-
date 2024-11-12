<?php

namespace App\Data\Dtos\Convocatorias;

class ConvocatoriaResponseListaDTO
{
    public $nombre;
    public $requisitos_minimos_puesto;
    public $descripcion_puesto;
    public $salario_puesto;
    public $nomina_convocatoria_id;
    public $fecha_apertura;
    public $fecha_cierre;

    public function __construct($convocatoria)
    {
        $this->nombre = $convocatoria->nombre;
        $this->requisitos_minimos_puesto = $convocatoria->requisitos_minimos_puesto;
        $this->descripcion_puesto = $convocatoria->descripcion_puesto;
        $this->salario_puesto = $convocatoria->salario_puesto;
        $this->nomina_convocatoria_id = $convocatoria->nomina_convocatoria_id;
        $this->fecha_apertura = $convocatoria->fecha_apertura;
        $this->fecha_cierre = $convocatoria->fecha_cierre;
    }

    public static function fromModel($convocatoria): self
    {
        return new self($convocatoria);
    }

}
