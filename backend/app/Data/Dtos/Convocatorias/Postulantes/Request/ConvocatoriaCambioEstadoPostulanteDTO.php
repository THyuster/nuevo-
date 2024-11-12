<?php

namespace App\Data\Dtos\Convocatorias\Postulantes\Request;

class ConvocatoriaCambioEstadoPostulanteDTO
{
    public $estado;
    public $motivoRechazo;
    public function __construct(array $data)
    {
        $this->estado = $data['estado'];
        $this->motivoRechazo = $data['motivo_rechazo'] ?? null;
    }
}
