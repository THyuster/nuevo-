<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Repository\RepositoryValidationBaseDatos;
use App\Utils\TransfersData\ModuloConfiguracion\ConsultasModulosNavegacion;
use App\Utils\Constantes\constantConsultations;
use App\Utils\MyFunctions;

class erp_modulosController extends Controller
{

    protected $dynamicsCrud;

    protected $validationBaseDatos;

    protected $consultasModulos;

    protected $constanteSql;

    protected $myFunctions;

    public function __construct(
        MyFunctions $myFunctions
    ) {
        $this->myFunctions = $myFunctions;
        $this->constanteSql = new constantConsultations;
        $this->consultasModulos = new ConsultasModulosNavegacion;
        $this->dynamicsCrud = new RepositoryDynamicsCrud;
        $this->validationBaseDatos = new RepositoryValidationBaseDatos;
    }

    public function index()
    {
        if (MyFunctions::validar_superadmin() === true) {
            $tiposAdministrador = $this->dynamicsCrud->sqlFunction("SELECT* FROM tipo_administrador");
            $modulos = $this->dynamicsCrud->sqlFunction($this->constanteSql->getModulosSinTodos());

            return view('modulo_configuracion.diseno_modulos.index', compact('modulos', 'tiposAdministrador'));
        }
        return view('error404');
    }

    public function getModulos()
    {
        //esta funcion no se estaba utilizando en ningun lugar entonces la desactive :) para el endpoint de javier
        // if (MyFunctions::validar_superadmin() === true) {
            return $this->dynamicsCrud->sqlFunction($this->constanteSql->getModulosSinTodos(), 1);
        // }
    }

    public function create(Request $request)
    {
        if (MyFunctions::validar_superadmin() === true) {
            return $this->consultasModulos->create($request->all(), $request);
        }
    }

    public function edit(Request $request)
    {
        if (MyFunctions::validar_superadmin() === true) {
            return $this->consultasModulos->edit($request->all(), $request);
        }
    }

    public function updateStatus($id)
    {
        if (MyFunctions::validar_superadmin() === true) {
            return $this->consultasModulos->changeStatusModulo($id);
        }
    }

    public function destroy($id)
    {
        if (MyFunctions::validar_superadmin() === true) {
            return $this->consultasModulos->delete($id);
        }
    }

    public function validationdb()
    {
      
        if (MyFunctions::validar_superadmin() === true) {
            return $this->validationBaseDatos->checkDataBase();
        }
    }
}