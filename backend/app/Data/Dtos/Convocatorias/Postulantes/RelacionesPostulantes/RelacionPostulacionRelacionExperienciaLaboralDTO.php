<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes;

class RelacionPostulacionRelacionExperienciaLaboralDTO
{
    public $postulanteId;
    public $postulanteExperienciaLaboralId;

    public function __construct($postulanteId, $postulanteExperienciaLaboralId)
    {
        $this->postulanteId = $postulanteId;
        $this->postulanteExperienciaLaboralId = $postulanteExperienciaLaboralId;
    }

    public function toArray()
    {
        return [
            'nomina_convocatoria_postulante_id' => $this->postulanteId,
            'nomina_convocatoria_postulante_experiencia_laboral_id' => $this->postulanteExperienciaLaboralId
        ];
    }
}
