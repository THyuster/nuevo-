<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Data\Dtos\Ordenes\Request\RequestOrdenCreateDTO;
use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloMantenimiento\Ordenes\IServicesOrdenes;
use Illuminate\Http\Request;

class mantenimiento_ordenesController extends Controller
{

    private IServicesOrdenes $_servicesOrdens;

    public function __construct(IServicesOrdenes $iServicesOrdenes)
    {
        $this->_servicesOrdens = $iServicesOrdenes;
    }

    public function crear(Request $request)
    {
        $requestOrdenCreateDTO = new RequestOrdenCreateDTO($request);
        
        return $this->_servicesOrdens->crearOrdenes($requestOrdenCreateDTO);
    }
    public function actualizar(Request $request, $id)
    {
        $requestOrdenCreateDTO = new RequestOrdenCreateDTO($request);

        return $this->_servicesOrdens->asignarOrdenes($requestOrdenCreateDTO, $id);
    }
    public function eliminar($id)
    {
        return $this->_servicesOrdens->eliminarOrdenes($id);
    }
    public function obtener()
    {
        return $this->_servicesOrdens->getOrdenesAll();
    }
}
