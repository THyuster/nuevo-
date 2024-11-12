<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes;

class RelacionPostulacionRelacionPersonalesDTO
{
    public $postulanteId;
    public $pesonalesId;

    public function __construct($postulanteId, $pesonalesId)
    {
        $this->postulanteId = $postulanteId;
        $this->pesonalesId = $pesonalesId;
    }

    public function toArray()
    {
        return [
            'postulante_id' => $this->postulanteId,
            'personales_id' => $this->pesonalesId
        ];
    }
}

