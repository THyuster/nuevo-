<?php

namespace App\Data\Dtos\Solicitudes\Response;

use App\Models\modulo_mantenimiento\mantenimiento_solicitudes as Solicitud;

/**
 * DTO para representar las solicitudes de mantenimiento.
 */
class SolicitudDTO
{
    public $id;

    public $idSolicitud;

    public $fechaSolicitud;

    public $fechaCierre;

    public $estadoId;

    public $fechaFinalizacion;

    public $terceroId;

    public $centroTrabajoId;


    public $prioridadId;

    public $tipoSolicitudId;

    public $equipoId;

    public $vehiculoId;

    public $observacion;

    public $rutaImagen;

    public $usuarioId;

    public $origen;

    public $idSignatures;

    public $createdAt;

    public $updatedAt;

    /**
     * SolicitudDTO constructor.
     *
     * @param Solicitud $mSolicitudes Instancia del modelo `mantenimiento_solicitudes`.
     */
    public function __construct(Solicitud $mSolicitudes)
    {
        $this->id = $mSolicitudes->id ?? null;
        $this->idSolicitud = $mSolicitudes->id_solicitud ?? null;
        $this->fechaSolicitud = $mSolicitudes->fecha_solicitud ?? null;
        $this->fechaCierre = $mSolicitudes->fecha_cierre ?? null;
        $this->estadoId = $mSolicitudes->estado_id ?? null;
        $this->fechaFinalizacion = $mSolicitudes->fecha_finalizacion ?? null;
        $this->terceroId = $mSolicitudes->tercero_id ?? null;
        $this->centroTrabajoId = $mSolicitudes->centro_trabajo_id ?? null;
        $this->prioridadId = $mSolicitudes->prioridad_id ?? null;
        $this->tipoSolicitudId = $mSolicitudes->tipo_solicitud_id ?? null;
        $this->equipoId = $mSolicitudes->equipo_id ?? null;
        $this->vehiculoId = $mSolicitudes->vehiculo_id ?? null;
        $this->observacion = $mSolicitudes->observacion ?? null;
        $this->rutaImagen = $mSolicitudes->ruta_imagen ?? null;
        $this->usuarioId = $mSolicitudes->usuario_id ?? null;
        $this->origen = $mSolicitudes->origen ?? null;
        $this->idSignatures = $mSolicitudes->id_signatures ?? null;
        $this->createdAt = $mSolicitudes->created_at ?? null;
        $this->updatedAt = $mSolicitudes->updated_at ?? null;
    }
}
