<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Erp\LicenseValidation;
use App\Utils\Constantes\Erp\SqlLicense;
use App\Utils\Constantes\ModuloConfiguracion\DisenoModulos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\MyFunctions;

class erp_licenciamientoController extends Controller
{
    private $repositoryDynamicsCrud;
    private $serviceLicense;
    private $myFunctions;
    private $sqlModules;
    private $sqlLicense;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->serviceLicense = new License;
        $this->myFunctions = new MyFunctions;
        $this->sqlModules = new DisenoModulos;
        $this->sqlLicense = new SqlLicense;
    }
    public function index()
    {
        $user = Auth::user();
        $resultado = MyFunctions::validar_modulo("superAdmin");
        $nombre_usuario = $user->name;

        $modules = $this->repositoryDynamicsCrud->sqlFunction($this->sqlModules->sqlGetModules());
        $group = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_grupo_empresarial");
        return view("superAdmin.licencias.index", compact('nombre_usuario',  'modules', 'group'));
    }


    public function create(LicenseValidation $request)
    {
        return $this->serviceLicense->create($request->all());
    }

    public function show()
    {
        $licenses = $this->repositoryDynamicsCrud->sqlFunction($this->sqlLicense->getRelationIndex());
        return $this->serviceLicense->getLicense($licenses);
    }


    public function getRelations()
    {
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_relacion_empresas");
    }


    public function update(Request $request, string $id)
    {
        return $this->serviceLicense->update($id, $request->all());
    }


    public function destroy(string $id)
    {
        return $this->serviceLicense->delete($id);
    }
    public function updateStatus(string $id)
    {
        return $this->serviceLicense->statusUpdate($id);
    }
}
