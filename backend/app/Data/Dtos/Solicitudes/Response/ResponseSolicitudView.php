<?php

namespace App\Data\Dtos\Solicitudes\Response;
use App\Models\modulo_mantenimiento\mantenimiento_solicitudes_view;

class ResponseSolicitudView
{
    public int $id;
    public string $id_solicitud;
    public string $fecha_solicitud;
    public ?string $fecha_cierre;
    public string $tipo_solicitud_descripcion;
    public string $centro_trabajo_descripcion;
    public ?string $equipo_descripcion;
    public ?string $matricula_vehiculo;
    public string $estado_descripcion;
    public ?string $imagen;
    public int $usuario_id;
    public string $DIAS_DE_RETRASO;
    public int $DIAS_TRANSCURRIDOS;

    public function __construct(mantenimiento_solicitudes_view $solicitudView)
    {
        $this->id = $solicitudView->id;
        $this->id_solicitud = $solicitudView->id_solicitud;
        $this->fecha_solicitud = $solicitudView->fecha_solicitud;
        $this->fecha_cierre = $solicitudView->fecha_cierre;
        $this->tipo_solicitud_descripcion = $solicitudView->tipo_solicitud_descripcion;
        $this->centro_trabajo_descripcion = $solicitudView->centro_trabajo_descripcion;
        $this->equipo_descripcion = $solicitudView->equipo_descripcion;
        $this->matricula_vehiculo = $solicitudView->matricula_vehiculo;
        $this->estado_descripcion = $solicitudView->estado_descripcion;
        $this->imagen = $solicitudView->imagen ? url($solicitudView->imagen) : url('');
        $this->usuario_id = $solicitudView->usuario_id;
        $this->DIAS_DE_RETRASO = $solicitudView->DIAS_DE_RETRASO;
        $this->DIAS_TRANSCURRIDOS = $solicitudView->DIAS_TRANSCURRIDOS;
    }

}
