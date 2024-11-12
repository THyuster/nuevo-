<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use App\Utils\MyFunctions;
use Illuminate\Http\Request;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloConfiguracion\DisenoMenus;
use App\Utils\TransfersData\ModuloConfiguracion\ConsultasMenus;
use App\Utils\Constantes\NavbarMenus\ConstantesInmersion;

class erp_menusController extends Controller
{

    protected $disenoMenus;
    protected $consultasMenus;
    protected $repositoryDynamicsCrud;
    protected $constantesInmersion;


    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->disenoMenus = new DisenoMenus;
        $this->consultasMenus = new ConsultasMenus;
        $this->constantesInmersion = new ConstantesInmersion;
    }

    public function index($id)
    {
        if (MyFunctions::validar_superadmin()) {
            $sql = $this->disenoMenus->sqlGetMenusByModuleId($id);
            $menus = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $sql = $this->disenoMenus->sqlGetModule($id);
            $descriptionModule = $this->repositoryDynamicsCrud->sqlFunction($this->constantesInmersion->RutaMenu($id));
            return view('modulo_configuracion.diseno_menus.index', compact('menus', 'id', 'descriptionModule'));
        }
        return view("error404");
    }

    public function create(Request $request)
    {
        if (MyFunctions::validar_superadmin()) {
            return $this->consultasMenus->createMenu($request->all());
        }
        
    }

    public function update(Request $request)
    {
        if (MyFunctions::validar_superadmin()) {
            return $this->consultasMenus->updateMenu($request->all());
        }
    }

    public function destroy($id)
    {
        if (MyFunctions::validar_superadmin()) {
            return $this->repositoryDynamicsCrud->deleteInfoAllOrById('erp_menuses',  $id);
        }
    }

    public function checkStatus($id)
    {
        if (MyFunctions::validar_superadmin()) {
            return $this->consultasMenus->changeStatusMenus($id);
        }
    }
}