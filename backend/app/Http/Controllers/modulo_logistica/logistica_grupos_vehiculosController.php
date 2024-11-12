<?php

namespace App\Http\Controllers\modulo_logistica;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloLogistica\ConstantesLogisticaGruposVehiculos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloLogistica\ServicelogisticaGruposVehiculos;
use Illuminate\Http\Request;

class logistica_grupos_vehiculosController extends Controller{
    protected $constantesLogisticaGruposVehiculos;
    protected $repository;
    protected $servicelogisticaGruposVehiculos;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->servicelogisticaGruposVehiculos = new ServicelogisticaGruposVehiculos;
        $this->constantesLogisticaGruposVehiculos = new ConstantesLogisticaGruposVehiculos;
    }
    public function index()
    {
        return view("modulo_logistica.grupo_vehiculos.index");
    }
    public function create(Request $request)
    {
       return $this->servicelogisticaGruposVehiculos->createLogisticaGruposVehiculos($request->all());
    }

    public function show()
    {   
        $sql = $this->constantesLogisticaGruposVehiculos->sqlSelectAll();
        return $this->repository->sqlFunction($sql);
    }

    public function update(Request $request, $id)
    {
        return $this->servicelogisticaGruposVehiculos->updateLogisticaGruposVehiculos($id,$request->all());
    }

    public function destroy($id)
    {
        return $this->servicelogisticaGruposVehiculos->deleteLogisticaGruposVehiculos($id);
    }
}
