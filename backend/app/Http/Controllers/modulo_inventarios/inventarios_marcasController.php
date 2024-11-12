<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloInventario\ConstantesMarcas;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceMarcas;
use Illuminate\Http\Request;

class inventarios_marcasController extends Controller
{
    
    protected $constantesMarcas;
    protected $repository;
    protected $serviceMarcas;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->serviceUnidades = new ServiceMarcas;
        $this->constantesMarcas = new ConstantesMarcas;
    }
    public function index()
    {
        return view("modulo_inventarios.marcas.index");
    }
    public function create(Request $request)
    {
       return $this->serviceUnidades->createMarcas($request->all());
    }

    public function show()
    {
        return $this->repository->sqlFunction($this->constantesMarcas->sqlSelectAll());
    }

    public function update(Request $request, $id)
    {
        return $this->serviceUnidades->updateMarcas($id,$request->all());
    }

    public function destroy($id)
    {
        return $this->serviceUnidades->deleteMarcas($id);
    }
}
