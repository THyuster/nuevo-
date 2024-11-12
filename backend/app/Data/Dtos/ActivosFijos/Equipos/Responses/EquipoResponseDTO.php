<?php

namespace App\Data\Dtos\ActivosFijos\Equipos\Responses;

class EquipoResponseDTO
{
    public $id;
    public $codigo;
    public $descripcion;
    public $grupo_equipo_id;
    public $fecha_adquisicion;
    public $fecha_instalacion;
    public $serial_interno;
    public $serial_equipo;
    public $modelo;
    public $marcaId;
    public $potencia;
    public $proveedorId;
    public $mantenimiento;
    public $horometro;
    public $costo;
    public $combustible;
    public $uso_diario;
    public $upm;
    public $area;
    public $labor;
    public $administradorId;
    public $ingenieroId;
    public $jefe_mantenimiento_id;
    public $operador_id;
    public $observaciones;
    public $ruta_imagen;
    public $estado;
    public $peso_kgs;
    public $altura_mts;
    public $ancho_mts;
    public $largo_mts;
    public $temp_centigrados;
    public $rpm;
    public $inventario_unidad_id;
    public $cabinado;
    public $created_at;
    public $updated_at;
    public function __construct($equipoRequestCreate)
    {
        $this->id = $equipoRequestCreate->id;
        $this->codigo = $equipoRequestCreate->codigo;
        $this->descripcion = $equipoRequestCreate->descripcion;
        $this->grupo_equipo_id = $equipoRequestCreate->grupo_equipo_id;
        $this->fecha_adquisicion = $equipoRequestCreate->fecha_adquisicion;
        $this->fecha_instalacion = $equipoRequestCreate->fecha_instalacion;
        $this->serial_interno = $equipoRequestCreate->serial_interno;
        $this->serial_equipo = $equipoRequestCreate->serial_equipo;
        $this->modelo = $equipoRequestCreate->modelo;
        $this->marcaId = $equipoRequestCreate->marcaId;
        $this->potencia = $equipoRequestCreate->potencia;
        $this->proveedorId = $equipoRequestCreate->proveedorId;
        $this->mantenimiento = $equipoRequestCreate->mantenimiento;
        $this->horometro = $equipoRequestCreate->horometro;
        $this->costo = $equipoRequestCreate->costo;
        $this->combustible = $equipoRequestCreate->combustible;
        $this->uso_diario = $equipoRequestCreate->uso_diario;
        $this->upm = $equipoRequestCreate->upm;
        $this->area = $equipoRequestCreate->area;
        $this->labor = $equipoRequestCreate->labor;
        $this->administradorId = $equipoRequestCreate->administradorId;
        $this->ingenieroId = $equipoRequestCreate->ingenieroId;
        $this->jefe_mantenimiento_id = $equipoRequestCreate->jefe_mantenimiento_id;
        $this->operador_id = $equipoRequestCreate->operador_id;
        $this->observaciones = $equipoRequestCreate->observaciones;
        $this->ruta_imagen = $equipoRequestCreate->ruta_imagen;
        $this->estado = $equipoRequestCreate->estado;
        $this->peso_kgs = $equipoRequestCreate->peso_kgs;
        $this->altura_mts = $equipoRequestCreate->altura_mts;
        $this->ancho_mts = $equipoRequestCreate->ancho_mts;
        $this->largo_mts = $equipoRequestCreate->largo_mts;
        $this->temp_centigrados = $equipoRequestCreate->temp_centigrados;
        $this->rpm = $equipoRequestCreate->rpm;
        $this->inventario_unidad_id = $equipoRequestCreate->inventario_unidad_id;
        $this->cabinado = boolval($equipoRequestCreate->cabinado);
        $this->created_at = $equipoRequestCreate->created_at;
        $this->updated_at = $equipoRequestCreate->updated_at;

    }
}
