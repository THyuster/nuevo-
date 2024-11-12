<?php

namespace App\Data\Dtos\Ordenes\Request;

class OrdenCreateDTO
{
    public $idSolicitud;
    public $idOrden;
    public $idUsuario;

    public function __construct($orden = null)
    {
        $this->idSolicitud = $orden->idSolicitud ?? null;
        $this->idOrden = $orden->idOrden ?? null;
        $this->idUsuario = $orden->idUsuario ?? null;
    }

    public function toArray()
    {
        return [
            "solicitud_id" => $this->idSolicitud,
            "id_orden" => $this->idOrden,
            "user_id" => $this->idUsuario
        ];
    }

}
