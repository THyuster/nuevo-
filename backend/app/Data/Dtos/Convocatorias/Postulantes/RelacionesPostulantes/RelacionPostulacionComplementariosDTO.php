<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes;

class RelacionPostulacionComplementariosDTO
{
    public $postulanteId;
    public $complementariosId;

    public function __construct($postulanteId, $complementariosId)
    {
        $this->postulanteId = $postulanteId;
        $this->complementariosId = $complementariosId;
    }

    public function toArray()
    {
        return [
            'postulante_id' => $this->postulanteId,
            'complementarios_id' => $this->complementariosId
        ];
    }
}
