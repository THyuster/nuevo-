<?php

namespace App\Data\Dtos\Ordenes\Request;
use App\Data\Dtos\Ordenes\Request\Tecnicos\TecnicosDTO;

class RequestAsignarOrden
{
    public RequestCreateSolicitudDTO|null $solicitud;

    /**
     * @var array<\App\Data\Dtos\Ordenes\Request\Tecnicos\TecnicosDTO>
     */
    public array $tecnicos = [];

    public function __construct($ordenRequestCreate)
    {
        $this->tecnicos = $ordenRequestCreate->orden ? array_map(function ($orden) {
            $tecnicoDTO = new TecnicosDTO(json_decode($orden));
            $tecnicoDTO->ordenId = $this->solicitud->solicitudId ?? $tecnicoDTO->ordenId;
            return $tecnicoDTO;
        }, $ordenRequestCreate->orden ?? []) : [];
    }
}
