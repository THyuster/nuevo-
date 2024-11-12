<?php

namespace App\Http\Controllers\modulo_contabilidad;
use App\Utils\TransfersData\moduloContabilidad\ThirdPartyData;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class contabilidad_tipos_tercerosController extends Controller
{   
    protected  $repositoryDynamicsCrud;
    protected $nameDataBase;
    protected $thirdPartyData;
    public function __construct() {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase =  "contabilidad_tipos_terceros";
        $this->thirdPartyData =  new ThirdPartyData;

    }
    public function index()
    {
        $types = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->nameDataBase");
        return view("modulo_contabilidad.tipos_terceros.index", compact('types') );
    }

    public function show(){
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->nameDataBase");
    }
    public function create(Request $request )
    {
        
        return $this->thirdPartyData->create($request->all());   
    }

    public function update(Request $request, $id)
    {
        return $this->thirdPartyData->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->thirdPartyData->delete($id);
    }

    public function thirdParty(){
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT descripcion FROM $this->nameDataBase");
    }

}