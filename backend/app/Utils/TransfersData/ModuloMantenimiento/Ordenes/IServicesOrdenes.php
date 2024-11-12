<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Ordenes;

use App\Data\Dtos\Ordenes\Request\RequestOrdenCreateDTO;
use Illuminate\Http\Request;

interface IServicesOrdenes
{
    public function crearOrdenes(RequestOrdenCreateDTO $requestOrdenCreateDTO);
    public function asignarOrdenes(RequestOrdenCreateDTO $requestOrdenCreateDTO, $id);
    public function eliminarOrdenes($id);
    public function getOrdenesAll();
    //public function getCamposSelectores();
//    public function getTerceros();
    //  public function getOrdenesID(int $id);
}
