<?php

namespace App\Http\Controllers\modulo_contabilidad;

use App\Models\modulo_contabilidad\contabilidad_tipos_identificaciones;
use App\Utils\TransfersData\moduloContabilidad\TypesIdentifications;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class contabilidad_tipos_identificacionesController extends Controller
{

    protected $repositoryDinamyCrud;
    protected $typesIdentifications;
    protected $nameDataBase;

    public function __construct()
    {
        $this->repositoryDinamyCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_tipos_identificaciones";
        $this->typesIdentifications = new TypesIdentifications;
        // $this->middleware('auth:api');
    }

    public function index()
    {
        return view("modulo_contabilidad.tipos_identificaciones.index");
    }
    public function show(Request $request)
    {
        if (!auth()->user()) {
            $empresaId = $request->input('empId', null);

            if (!$empresaId) {
                return [];
            }

            $connection = $this->repositoryDinamyCrud->getConnectioByIdEmpresa($empresaId);

            if (!$connection) {
                return [];
            }

            $tiposIdentificaciones = contabilidad_tipos_identificaciones::on($connection)->get()->toArray();

            return $tiposIdentificaciones;
        }

        return $this->repositoryDinamyCrud->sqlFunction("SELECT * FROM $this->nameDataBase");
    }


    public function create(Request $request)
    {
        return $this->typesIdentifications->create($request->all());
    }


    public function update(Request $request, $id)
    {
        return $this->typesIdentifications->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->typesIdentifications->delete($id);
    }
}