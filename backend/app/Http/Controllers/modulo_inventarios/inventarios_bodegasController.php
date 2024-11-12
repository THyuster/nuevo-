<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloInventario\ConstantesBodega;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceBodega;
use Illuminate\Http\Request;

class inventarios_bodegasController extends Controller
{
    protected $constantesBodega;
    protected $repository;
    protected $serviceBodega;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->serviceBodega = new ServiceBodega;
        $this->constantesBodega = new ConstantesBodega;
    }

    public function index()
    {
        $sucursales = $this->repository->sqlFunction($this->constantesBodega->sqlSucursalesAll());
        return view('modulo_inventarios.bodegas.index', compact('sucursales'));
    }

    public function show()
    {
        return $this->repository->sqlFunction($this->constantesBodega->sqlSelectAll());
    }

    public function create(Request $request)
    {
        return $this->serviceBodega->createBodega($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->serviceBodega->updateBodega($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->serviceBodega->delete($id);
    }

    public function editEstado($id)
    {
        return $this->serviceBodega->updateStatusBodega($id);
    }
}