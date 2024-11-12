<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\Responses\Convocatorias;

class ConvocatoriaResponse
{
    public $nomina_cargo_id;
    public $nombre;
    public $requisitos_minimos_puesto;
    public $descripcion_puesto;
    public $salario_puesto;
    public $codigo_cargo;
    public $nomina_convocatoria_id;
    public $fecha_apertura;
    public $fecha_cierre;
    public $numero_puestos;
    public $activa;
    public $created_at;
    public $updated_at;

    public function __construct($convocatoria)
    {
        // $this->var = $convocatoria;
        $this->nomina_cargo_id = $convocatoria->nomina_cargo_id;
        $this->nombre = $convocatoria->nombre;
        $this->requisitos_minimos_puesto = $convocatoria->requisitos_minimos_puesto;
        $this->descripcion_puesto = $convocatoria->descripcion_puesto;
        $this->salario_puesto = $convocatoria->salario_puesto;
        $this->codigo_cargo = $convocatoria->codigo_cargo;
        $this->nomina_convocatoria_id = $convocatoria->nomina_convocatoria_id;
        $this->fecha_apertura = $convocatoria->fecha_apertura;
        $this->fecha_cierre = $convocatoria->fecha_cierre;
        $this->numero_puestos = $convocatoria->numero_puestos;
        $this->activa = $convocatoria->activa;
        $this->created_at = $convocatoria->created_at;
        $this->updated_at = $convocatoria->updated_at;
    }

}
