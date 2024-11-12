<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes;

class RelacionPostulacionRelacionAcademiaDTO
{
    public $postulanteId;
    public $academiaId;

    public function __construct($postulanteId, $academiaId)
    {
        $this->postulanteId = $postulanteId;
        $this->academiaId = $academiaId;
    }

    public function toArray()
    {
        return [
            'postulante_id' => $this->postulanteId,
            'academica_id' => $this->academiaId
        ];
    }
}
