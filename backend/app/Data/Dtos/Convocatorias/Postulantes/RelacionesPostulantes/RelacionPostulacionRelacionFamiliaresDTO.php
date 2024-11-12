<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes;

class RelacionPostulacionRelacionFamiliaresDTO
{
    public $postulanteId;
    public $familiaresId;

    public function __construct($postulanteId, $familiaresId)
    {
        $this->postulanteId = $postulanteId;
        $this->familiaresId = $familiaresId;
    }

    public function toArray()
    {
        return [
            'postulante_id' => $this->postulanteId,
            'familiares_id' => $this->familiaresId
        ];
    }
}
