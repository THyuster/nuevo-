<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloInventario\ConstantesTipoArticulos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceTipoArticulos;
use Illuminate\Http\Request;

class inventarios_tipos_articulosController extends Controller
{
    protected $constantesTipoArticulos;
    protected $repository;
    protected $serviceTipoArticulos;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->serviceTipoArticulos = new ServiceTipoArticulos;
        $this->constantesTipoArticulos = new ConstantesTipoArticulos;
    }
    public function index()
    {
        return view('modulo_inventarios.tipos_articulos.index');
    }


    public function create(Request $request)
    {
        return $this->serviceTipoArticulos->createTipoArticulos($request->all());
    }

    public function show()
    {
       return $this->repository->sqlFunction($this->constantesTipoArticulos->sqlSelectAll());
    }


    public function update(Request $request, $id)
    {
        return $this->serviceTipoArticulos->updateTipoArticulos($id,$request->all());
    }

    public function destroy($id)
    {
        return $this->serviceTipoArticulos->deleteGrupoArticulos($id);
    }
}
