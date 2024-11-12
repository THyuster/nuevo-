<?php

namespace App\Data\Dtos\Ordenes\Request;
use App\Data\Dtos\Ordenes\Request\Tecnicos\TecnicosDTO;
use App\Data\Dtos\Solicitudes\Request\RequestCreateSolicitudDTO;

class RequestOrdenCreateDTO
{
    public RequestCreateSolicitudDTO|null $solicitud;

    /**
     * @var array<TecnicosDTO>
     */
    public array $tecnicos = [];

    public function __construct($ordenRequestCreate)
    {
        $this->solicitud = $ordenRequestCreate->solicitud ? new RequestCreateSolicitudDTO(json_decode($ordenRequestCreate->solicitud)) : [];
        $this->solicitud->rutaImagen = $ordenRequestCreate->ruta_imagen ?? null;
        $this->tecnicos = $ordenRequestCreate->orden ? array_map(function ($orden) {
            $tecnicoDTO = new TecnicosDTO(json_decode($orden));
            $tecnicoDTO->ordenId = $this->solicitud->solicitudId ?? $tecnicoDTO->ordenId;
            return $tecnicoDTO;
        }, $ordenRequestCreate->orden ?? []) : [];
    }

}
