<?php

// interface cl
namespace App\Utils\TransfersData\ModuloMantenimiento;

use Illuminate\Http\Request;

interface IServicesItemsDiagnostico
{
    public function crearItemsDiagnostico($entidadTiposItemsDiagnosticos);
    public function actualizarItemsDiagnostico($entidadTiposItemsDiagnosticos);
    public function eliminarItemsDiagnostico($id);
    public function obtenerTodosItemsDiagnostico();
    public function obtenerItemsTipoOrden(int $actaId, $idActa);
    public function obtenerTodosItemsDiagnosticoConRespuesta();
    public function actualizarEstadoItem($id);
    public function buscarCodigoItem(string $codigo, int $id);
    public function buscarItemsDiagnostico(int $id);
}