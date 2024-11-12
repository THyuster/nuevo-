<?php

namespace App\Data\Dtos\Convocatorias\Convocatoria\Response;
use App\Models\NominaModels\Convocatorias\ConvocatoriaView;
use App\Utils\MyFunctions;
use DateTime;

class ConvocatoriaViewResponseDTO
{
    public $id;
    public $nombre;
    public $requisitos;
    public $descripcion;
    public $codigo;
    public $salario;
    public $puestos;
    public $fechaApertura;
    public $fechaCierre;
    public $estado;
    public $created_at;
    public $updated_at;
    /**
     * 
     * @param ConvocatoriaView $convocotariaViewModel
     */
    public function __construct($convocotariaViewModel)
    {
        $fechaActual = new DateTime();
        $this->id = $convocotariaViewModel->nomina_convocatoria_id;
        $this->descripcion = $convocotariaViewModel->descripcion_puesto;
        $this->salario = $convocotariaViewModel->salario_puesto;
        $this->codigo = $convocotariaViewModel->codigo_cargo;
        $this->puestos = $convocotariaViewModel->numero_puestos;
        $this->requisitos = $convocotariaViewModel->requisitos_minimos_puesto;
        $this->nombre = $convocotariaViewModel->nombre;
        $this->fechaApertura = $convocotariaViewModel->fecha_apertura;
        $this->fechaCierre = $convocotariaViewModel->fecha_cierre;
        $this->created_at = $convocotariaViewModel->created_at;
        $this->updated_at = $convocotariaViewModel->updated_at;
        $this->estado = !(new DateTime($this->fechaCierre) <= $fechaActual) ? 'Activa' : 'Inactiva';
    }
}
