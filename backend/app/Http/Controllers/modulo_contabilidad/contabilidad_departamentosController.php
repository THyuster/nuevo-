<?php

namespace App\Http\Controllers\modulo_contabilidad;
use App\Models\modulo_contabilidad\contabilidad_departamentos;
use App\Utils\TransfersData\moduloContabilidad\DepartmentData;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\modulo_contabilidad\DepartmentsValidation;
use Illuminate\Http\Request;

class contabilidad_departamentosController extends Controller
{
    protected $repositoryDinamyCrud;
    protected $departmentData;
    public function __construct() {
        $this->repositoryDinamyCrud = new RepositoryDynamicsCrud;
        $this->departmentData = new DepartmentData;
    }
    public function index()
    {
        $departaments = $this->repositoryDinamyCrud->sqlFunction("SELECT * FROM contabilidad_departamentos");
        return view("modulo_contabilidad.departamentos.index", compact('departaments'));
    }


    public function show(Request $request){
        if (!auth()->user()) {
            $empresaId = $request->input('empId', null);

            if (!$empresaId) {
                return [];
            }

            $connection = $this->repositoryDinamyCrud->getConnectioByIdEmpresa($empresaId);

            if (!$connection) {
                return [];
            }

            $contabilidadDepartamentos = contabilidad_departamentos::on($connection)->get()->toArray();

            return $contabilidadDepartamentos;
        }
        return $this->repositoryDinamyCrud->sqlFunction("SELECT * FROM contabilidad_departamentos");
    }

    public function create(DepartmentsValidation $request)
    {
        return $this->departmentData->create($request->all());
    }

 
    public function update(Request $request, $id)
    {
        return $this->departmentData->update($id, $request->all());
    }
    
    public function destroy($id)
    {
        return $this->departmentData->delete($id);
    }
}