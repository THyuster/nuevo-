<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloInventario\ConstantesGrupoArticulos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceGrupoArticulos;
use Illuminate\Http\Request;

class inventarios_grupo_articulosController extends Controller
{
    protected $constantesGrupoArticulos;
    protected $repository;
    protected $serviceGrupoArticulos;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->serviceGrupoArticulos = new ServiceGrupoArticulos;
        $this->constantesGrupoArticulos = new ConstantesGrupoArticulos;
    }
    public function index()
    {
        return view('modulo_inventarios.grupo_articulos.index');
    }

    public function create(Request $request)
    {
        return $this->serviceGrupoArticulos->createGrupoArticulos($request->all());
    }

    public function show()
    {
        return $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlSelectAll());
    }

    public function update(Request $request, $id)
    {
        return $this->serviceGrupoArticulos->updateGrupoArticulos($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->serviceGrupoArticulos->deleteGrupoArticulos($id);
    }
}