<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloInventario\ConstantesGruposContables;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceGruposContables;
use Illuminate\Http\Request;

class inventarios_grupos_contablesController extends Controller
{
    protected $constantesGruposContables;
    protected $repository;
    protected $serviceGruposContables;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->serviceGruposContables = new ServiceGruposContables;
        $this->constantesGruposContables = new ConstantesGruposContables;
    }
    public function index()
    {
        return view('modulo_inventarios.grupos_contables.index');
    }

    public function create(Request $request)
    {
        return $this->serviceGruposContables->createGruposContables($request->all());
    }

    public function show()
    {
       return $this->repository->sqlFunction($this->constantesGruposContables->sqlSelectAll());
    }


    public function update(Request $request, $id)
    {
        return $this->serviceGruposContables->updateGruposContables($id,$request->all());
    }

    public function destroy($id)
    {
        return $this->serviceGruposContables->deleteGruposContables($id);
    }
}
