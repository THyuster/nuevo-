<?php

namespace App\Data\Dtos\Solicitudes\Request;
use Illuminate\Http\UploadedFile;

class RequestCreateSolicitudDTO
{
    public $solicitudId;
    public int $idUsuario;
    public $equipoId;
    public $vehiculoId;
    public $prioridadId;
    public $tipoSolicitudId;
    public $observacion;
    public $origen;
    public UploadedFile|null $rutaImagen;
    public $fechaSolicitud;
    public $fechaCierre;
    public $centroTrabajoId;
    public $estadoId;
    public string|null $imagen;
    public function __construct($solicitud)
    {
        $this->solicitudId = $solicitud->id_solicitud ?? uuid_create();
        $this->idUsuario = $solicitud->usuario_id ?? auth()->user()->getAuthIdentifier();
        $this->equipoId = $solicitud->equipo_id ?? null;
        $this->vehiculoId = $solicitud->vehiculo_id ?? null;
        $this->prioridadId = $solicitud->prioridad_id ?? 0;
        $this->estadoId = $solicitud->estado_id ?? 1;
        $this->rutaImagen = $solicitud->ruta_imagen ?? null;
        $this->centroTrabajoId = $solicitud->nomina_centro_trabajo_id ?? 0;
        $this->observacion = $solicitud->observaciones ?? 0;
        $this->tipoSolicitudId = $solicitud->tipo_solicitud_id ?? 0;
        $this->fechaSolicitud = $solicitud->fecha_auditoria ?? 0;
        $this->fechaCierre = $solicitud->fecha_plazo ?? 0;
        $this->origen = $solicitud->origen ?? 0;
        $this->imagen = $solicitud->imagen ?? null;
    }

    public function toArray()
    {
        return [
            "id_solicitud" => $this->solicitudId,
            "fecha_solicitud" => $this->fechaSolicitud,
            "fecha_cierre" => $this->fechaCierre,
            "estado_id" => $this->estadoId,
            "centro_trabajo_id" => $this->centroTrabajoId,
            "prioridad_id" => $this->prioridadId,
            "tipo_solicitud_id" => $this->tipoSolicitudId,
            "equipo_id" => $this->equipoId,
            "vehiculo_id" => $this->vehiculoId,
            "observacion" => $this->observacion,
            "ruta_imagen" => $this->imagen,
            "usuario_id" => $this->idUsuario,
            "origen" => $this->origen,
        ];
    }
}
