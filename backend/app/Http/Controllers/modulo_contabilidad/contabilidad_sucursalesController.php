<?php

namespace App\Http\Controllers\modulo_contabilidad;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\moduloContabilidad\BranchData;
use App\Http\Requests\modulo_contabilidad\BranchValidation;

use Illuminate\Http\Request;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlBranch;


class contabilidad_sucursalesController extends Controller
{

     protected $repositoryDinamyCrud;
     protected $branchData;
     protected $nameDataBase;
     protected $sqlBranch;
    
    public function __construct() {
        $this->repositoryDinamyCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase= "contabilidad_sucursales";
        $this->branchData= new BranchData;
        $this->sqlBranch= new SqlBranch;

    }   


    public function index()
    {
        $municipalitys = $this->repositoryDinamyCrud->sqlFunction('SELECT * FROM contabilidad_municipios');
        $companies = $this->repositoryDinamyCrud->sqlFunction('SELECT * FROM contabilidad_empresas');
        $branchs = $this->repositoryDinamyCrud->sqlFunction($this->sqlBranch->getSqlBranchByMunicipalityByDepartment());
        return view("modulo_contabilidad.sucursales.index", compact('branchs', 'municipalitys', 'companies'));
    }

    public function show(){
        return $this->repositoryDinamyCrud->sqlFunction($this->sqlBranch->getSqlBranchByMunicipalityByDepartment());
    }


    public function create(BranchValidation $request)
    {
        return $this->branchData->create($request->all());
        
    }

    public function update(BranchValidation $request, $id)
    {
        return $this->branchData->update($id, $request->all());
    }


    public function destroy($id)
    {
        
        return $this->branchData->delete($id);
    }

    public function changeStatus($id){
        
        return $this->branchData->changeStatus($id);
    }
}