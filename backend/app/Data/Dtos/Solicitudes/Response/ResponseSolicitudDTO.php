<?php

namespace App\Data\Dtos\Solicitudes\Response;

class ResponseSolicitudDTO
{
    public int $id;
    public string $id_solicitud;
    public ?string $created_at;
    public ?string $updated_at;
    public string $fecha_solicitud;
    public string $fecha_cierre;
    public int $estado_id;
    public ?string $fecha_finalizacion;
    // public ?int $tercero_id;
    public int $centro_trabajo_id;
    public int $prioridad_id;
    public int $tipo_solicitud_id;
    public ?string $equipo_id;
    public ?string $vehiculo_id;
    public ?string $observacion;
    public ?string $ruta_imagen;
    public int $usuario_id;
    public int $origen;
    public ?string $id_signatures;

    // Campos añadidos para manejar datos relacionados
    public string $estado_descripcion;
    public ?string $centro_trabajo_descripcion;
    public ?string $prioridad_descripcion;
    public ?string $tipo_solicitud_descripcion;
    public ?string $equipo_descripcion;
    public ?string $matricula_vehiculo;

    // Campos adicionales para los datos del usuario
    public string $Usuario_solicitud;
    public ?string $nombres_solicitante;
    // public ?string $movil_solicitante;
    public string $email_solicitante;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->id_solicitud = $data->id_solicitud;
        $this->created_at = $data->created_at ?? null;
        $this->updated_at = $data->updated_at ?? null;
        $this->fecha_solicitud = $data->fecha_solicitud;
        $this->fecha_cierre = $data->fecha_cierre;
        $this->estado_id = $data->estado_id;
        $this->fecha_finalizacion = $data->fecha_finalizacion ?? null;
        // $this->tercero_id = $data->tercero_id ?? null;
        $this->centro_trabajo_id = $data->centro_trabajo_id;
        $this->prioridad_id = $data->prioridad_id;
        $this->tipo_solicitud_id = $data->tipo_solicitud_id;
        $this->equipo_id = $data->equipo_id ?? null;
        $this->vehiculo_id = $data->vehiculo_id ?? null;
        $this->observacion = $data->observacion ?? null;
        $this->ruta_imagen = $data->ruta_imagen ? url($data->ruta_imagen) : null;
        $this->usuario_id = $data->usuario_id;
        $this->origen = $data->origen;
        $this->id_signatures = $data->id_signatures ?? null;

        // Datos relacionados
        $this->estado_descripcion = $data->estado->nombre ?? '';
        $this->centro_trabajo_descripcion = $data->centroTrabajo->descripcion ?? null;
        $this->prioridad_descripcion = $data->prioridad->nombre ?? null;
        $this->tipo_solicitud_descripcion = $data->tipoSolicitud->descripcion ?? null;
        $this->equipo_descripcion = $data->equipo->codigo ?? null; // Si `codigo` no está presente, ajustar según sea necesario
        $this->matricula_vehiculo = $data->vehiculo->placa ?? null;

        // Datos del usuario
        $this->Usuario_solicitud = $data->usuario->name ?? '';
        // $this->nombres_solicitante = $data->tercero->nombre1 ??? . ' ' . $data->tercero->nombre2 ?? null; // Ajustar según la estructura real
        $this->movil_solicitante = $data->tercero->movil ?? null;
        $this->email_solicitante = $data->usuario->email ?? '';
    }

}
