<?php

namespace App\Data\Dtos\ActivosFijos\Equipos\Request;
use Illuminate\Http\UploadedFile;

class EquiposRequestCreateDTO
{
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
    public array|UploadedFile|null|string $ruta_imagen;
    public $estado;
    public $peso_kgs;
    public $altura_mts;
    public $ancho_mts;
    public $largo_mts;
    public $temp_centigrados;
    public $rpm;
    public $inventario_unidad_id;
    public $cabinado;

    public function __construct($equipoRequestCreate)
    {
        $this->codigo = $equipoRequestCreate["codigo"] ?? null;
        $this->descripcion = $equipoRequestCreate["descripcion"] ?? null;
        $this->grupo_equipo_id = $equipoRequestCreate["grupo_equipo_id"] ?? null;
        $this->fecha_adquisicion = $equipoRequestCreate["fecha_adquisicion"] ?? null;
        $this->fecha_instalacion = $equipoRequestCreate["fecha_instalacion"] ?? null;
        $this->serial_interno = $equipoRequestCreate["serial_interno"] ?? null;
        $this->serial_equipo = $equipoRequestCreate["serial_equipo"] ?? null;
        $this->modelo = $equipoRequestCreate["modelo"] ?? null;
        $this->marcaId = $equipoRequestCreate["marcaId"] ?? null;
        $this->potencia = $equipoRequestCreate["potencia"] ?? null;
        $this->proveedorId = $equipoRequestCreate["proveedorId"] ?? null;
        $this->mantenimiento = $equipoRequestCreate["mantenimiento"] ?? null;
        $this->horometro = $equipoRequestCreate["horometro"] ?? null;
        $this->costo = $equipoRequestCreate["costo"] ?? null;
        $this->combustible = $equipoRequestCreate["combustible"] ?? null;
        $this->uso_diario = $equipoRequestCreate["uso_diario"] ?? null;
        $this->upm = $equipoRequestCreate["upm"] ?? null;
        $this->area = $equipoRequestCreate["area"] ?? null;
        $this->labor = $equipoRequestCreate["labor"] ?? null;
        $this->administradorId = $equipoRequestCreate["administradorId"] ?? null;
        $this->ingenieroId = $equipoRequestCreate["ingenieroId"] ?? null;
        $this->jefe_mantenimiento_id = $equipoRequestCreate["jefe_mantenimiento_id"] ?? null;
        $this->operador_id = $equipoRequestCreate["operador_id"] ?? null;
        $this->observaciones = $equipoRequestCreate["observaciones"] ?? null;
        $this->ruta_imagen = $equipoRequestCreate["ruta_imagen"] ?? null;
        $this->estado = $equipoRequestCreate["estado"] ?? 1;
        $this->peso_kgs = $equipoRequestCreate["peso_kgs"] ?? null;
        $this->altura_mts = $equipoRequestCreate["altura_mts"] ?? null;
        $this->ancho_mts = $equipoRequestCreate["ancho_mts"] ?? null;
        $this->largo_mts = $equipoRequestCreate["largo_mts"] ?? null;
        $this->temp_centigrados = $equipoRequestCreate["temp_centigrados"] ?? null;
        $this->rpm = $equipoRequestCreate["rpm"] ?? null;
        $this->inventario_unidad_id = $equipoRequestCreate["inventario_unidad_id"] ?? null;
        $this->cabinado = boolval($equipoRequestCreate["cabinado"]) ?? null;
    }

    public function toArray()
    {
        return [
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'grupo_equipo_id' => $this->grupo_equipo_id,
            'fecha_adquisicion' => $this->fecha_adquisicion,
            'fecha_instalacion' => $this->fecha_instalacion,
            'serial_interno' => $this->serial_interno,
            'serial_equipo' => $this->serial_equipo,
            'modelo' => $this->modelo,
            'marcaId' => $this->marcaId,
            'potencia' => $this->potencia,
            'proveedorId' => $this->proveedorId,
            'mantenimiento' => $this->mantenimiento,
            'horometro' => $this->horometro,
            'costo' => $this->costo,
            'combustible' => $this->combustible,
            'uso_diario' => $this->uso_diario,
            'upm' => $this->upm,
            'area' => $this->area,
            'labor' => $this->labor,
            'administradorId' => $this->administradorId,
            'ingenieroId' => $this->ingenieroId,
            'jefe_mantenimiento_id' => $this->jefe_mantenimiento_id,
            'operador_id' => $this->operador_id,
            'observaciones' => $this->observaciones,
            'ruta_imagen' => $this->ruta_imagen,
            'estado' => $this->estado,
            'peso_kgs' => $this->peso_kgs,
            'altura_mts' => $this->altura_mts,
            'ancho_mts' => $this->ancho_mts,
            'largo_mts' => $this->largo_mts,
            'temp_centigrados' => $this->temp_centigrados,
            'rpm' => $this->rpm,
            'inventario_unidad_id' => $this->inventario_unidad_id,
            'cabinado' => $this->cabinado,
        ];
    }
}
