<?php

// interface cl
namespace App\Utils\TransfersData\ModuloMantenimiento;

use Illuminate\Http\Request;

interface IServicesActas
{
    public function obtenerTodosActas();
    public function crearActas($entidadTiposActas);
    public function actualizarActas($id, $entidadTiposActas);
    public function obtenerCentroTrabajo($entidadTiposActas);
    // public function buscarActas(int $id);
    public function obtenerVehiculoOEquipo($data);
    public function tecnicosAsociadasOrden($ordenId);
}
