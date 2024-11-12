<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\OrdenesTecnicos;

use Illuminate\Http\Request;

interface IServicesOrdenesTecnicos
{
    public function crearOrdenesTecnicos($request);
    public function actualizarOrdenesTecnicos($request, $id);
    public function eliminarOrdenesTecnicos($id);
    public function getOrdenesTecnicos();
    // public function actualizarEstadoSolicitud($id, $estado);
    //public function getCamposSelectores();
//    public function getTerceros();
    //  public function getOrdenesID(int $id);
}
