<?php

namespace App\Data\Dtos\Ordenes\Request\Tecnicos;

class TecnicosDTO
{
    public $tipoOrdenId;
    public $tecnicoId;
    public $ordenId;

    public function __construct($tecnico)
    {
        $this->tipoOrdenId = $tecnico->tipo_orden_id ?? null;
        $this->tecnicoId = $tecnico->tecnico_id ?? null;
        $this->ordenId = $tecnico->orden_id ?? uuid_create();
    }

    public function toArray()
    {
        return [
            "tipo_orden_id" => $this->tipoOrdenId,
            "tecnico_id" => $this->tecnicoId,
            "orden_id" => $this->ordenId
        ];
    }
}
