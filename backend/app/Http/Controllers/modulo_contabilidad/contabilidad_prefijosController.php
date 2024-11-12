<?php

namespace App\Http\Controllers\modulo_contabilidad;

use App\Utils\TransfersData\moduloContabilidad\Prefixes;

use App\Http\Controllers\Controller;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Http\Request;

class contabilidad_prefijosController extends Controller
{
    protected $prefixes;
    protected $repositoryDynamicsCrud;
    protected $nameDataBase;

    public function __construct()
    {
        $this->prefixes = new Prefixes;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_prefijos";
    }

    public function index()
    {
        return view("modulo_contabilidad.prefijos.index");
    }

    public function create(Request $request)
    {
        return $this->prefixes->create($request->all());
    }


    public function show()
    {
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM contabilidad_prefijos ");
    }


    public function update(Request $request, string $id)
    {
        
        return $this->prefixes->update($id, $request->all());
    }


    public function destroy(string $id)
    {
    
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    public function updateStatus( string $id){
        return $this->prefixes->updateStatus($id);
    }
}
