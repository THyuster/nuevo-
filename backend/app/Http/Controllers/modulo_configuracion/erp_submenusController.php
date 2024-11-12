<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use App\Utils\MyFunctions;
use Illuminate\Http\Request;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\ConsultasSubmenus;
use App\Utils\Constantes\ModuloConfiguracion\DisenoSubmenus;
use App\Utils\Constantes\NavbarMenus\ConstantesInmersion;

class erp_submenusController extends Controller
{
  protected $consultasSubmenus;
  protected $repositoryDynamicsCrud;
  protected $constantesSubmenus;
  protected $constantesInmersion;

  public function __construct()
  {
    $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    $this->consultasSubmenus = new ConsultasSubmenus;
    $this->constantesSubmenus = new DisenoSubmenus;
    $this->constantesInmersion = new ConstantesInmersion;
  }

  public function index($id)
  {
    if (MyFunctions::validar_superadmin() === true) {
      $submenus = $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenus->getSqlViewBySubMenuses($id));
      $menus = $this->repositoryDynamicsCrud->sqlFunction($this->constantesSubmenus->getSqlViewsMenuses($id));
      $construccionInmersion = $this->repositoryDynamicsCrud->sqlFunction($this->constantesInmersion->RutaSubmenus($id));
      return (empty($menus)) ? view('error404') : view('modulo_configuracion.diseno_submenus.index', compact('submenus', 'id', 'construccionInmersion'));
    }
    return view('error404');
  }

  public function create($id, Request $request)
  {
    if (MyFunctions::validar_superadmin() === true) {
      return $this->consultasSubmenus->create($request->all(), $id);
    }
  }

  public function update(Request $request, $id)
  {
    if (MyFunctions::validar_superadmin() === true) {
      return $this->consultasSubmenus->update($id, $request->all());
    }
  }

  public function destroy($id)
  {
    if (MyFunctions::validar_superadmin() === true) {
      return $this->consultasSubmenus->delete($id);
    }
  }

  public function changeStatus($id)
  {
    if (MyFunctions::validar_superadmin() === true) {
      return $this->consultasSubmenus->changeStatus($id);
    }
  }
}