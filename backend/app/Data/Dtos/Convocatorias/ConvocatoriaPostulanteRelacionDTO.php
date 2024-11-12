<?php

namespace App\Data\Dtos\Convocatorias;

class ConvocatoriaPostulanteRelacionDTO
{
    public $id;
    public $convocatorias_id;
    public $postulante_id;
    public $fecha_postulacion;
    public $estado;
    public $created_at;
    public $updated_at;
    public function __construct($convocotariaPostulanteRelacion)
    {
        $this->id = $convocotariaPostulanteRelacion["id"];
        $this->convocatorias_id = $convocotariaPostulanteRelacion['convocatorias_id'];
        $this->postulante_id = $convocotariaPostulanteRelacion['postulante_id'];
        $this->fecha_postulacion = $convocotariaPostulanteRelacion['fecha_postulacion'];
        $this->estado = ($convocotariaPostulanteRelacion['estado'] == null)
            ? 'Nuevo'
            : (($convocotariaPostulanteRelacion['estado'] == 1)
                ? 'Aprobado'
                : 'Rechazado');
        $this->created_at = $convocotariaPostulanteRelacion['created_at'];
        $this->updated_at = $convocotariaPostulanteRelacion['updated_at'];
    }
}
