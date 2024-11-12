<?php

namespace App\Data\Dtos\Contabilidad\Identificaciones;

class identificacionUserDTO
{
    public $tipoidentificacionId;
    public $nombre;
    public $numero;

    public function __construct($tipoIdentificacionId, $nombre, $numero)
    {
        $this->tipoidentificacionId = $tipoIdentificacionId ?? null;
        $this->nombre = $nombre ?? null;
        $this->numero = $numero ?? null;
    }
}
