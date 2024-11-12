<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes;

class RelacionPostulanteConvocatoriaDTO
{
    public $convocatorias_id;
    public $postulante_id;

    public function __construct($convocatorias_id, $postulante_id)
    {
        $this->convocatorias_id = $convocatorias_id;
        $this->postulante_id = $postulante_id;
    }

    public function toArray()
    {
        return [
            "convocatorias_id" => $this->convocatorias_id,
            "postulante_id" => $this->postulante_id,
        ];
    }
}


