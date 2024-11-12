<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloInventario\ConstantesUnidades;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceUnidades;
use Illuminate\Http\Request;

class inventarios_unidadesController extends Controller
{
    protected $constantesUnidades;
    protected $repository;
    protected $serviceUnidades;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->serviceUnidades = new ServiceUnidades;
        $this->constantesUnidades = new ConstantesUnidades;
    }
    public function index()
    {
        return view("modulo_inventarios.unidades.index");
    }
    public function create(Request $request)
    {
       return $this->serviceUnidades->createUnidad($request->all());
    }

    public function show()
    {
        return $this->repository->sqlFunction($this->constantesUnidades->sqlSelectAll());
    }

    public function update(Request $request, $id)
    {
        return $this->serviceUnidades->updateUnidad($id,$request->all());
    }

    public function destroy($id)
    {
        return $this->serviceUnidades->deleteUnidad($id);
    }
}