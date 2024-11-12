<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\MyFunctions;
use App\Utils\Constantes\ModuloConfiguracion\DisenoVistas;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\ConsultasVistas;
use App\Utils\Constantes\NavbarMenus\ConstantesMenu;
use App\Utils\Constantes\NavbarMenus\ConstantesInmersion;

class erp_vistasController extends Controller
{
    protected $constantesDisenoVista;
    protected $repositoryDynamicsCrud;
    protected $disenoVistas;
    protected $myFuctions;
    protected $constantesMenus;
    protected $constantesInmersion;


    public function __construct()
    {
        $this->constantesDisenoVista = new DisenoVistas;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->disenoVistas = new ConsultasVistas;
        $this->myFuctions = new MyFunctions;
        $this->constantesMenus = new ConstantesMenu;
        $this->constantesInmersion = new ConstantesInmersion;

    }

    public function index($id)
    {
        if (MyFunctions::validar_superadmin() === true) {
            $views = $this->repositoryDynamicsCrud->sqlFunction($this->constantesDisenoVista->getSqlViewByViews($id));
            $submenus = $this->repositoryDynamicsCrud->sqlFunction($this->constantesDisenoVista->getSqlViewsSubmenus($id));
            $construccionInmersion = $this->repositoryDynamicsCrud->sqlFunction($this->constantesInmersion->RutaVista($id));
            return (empty($submenus)) ? view('error404') :
                view('modulo_configuracion.diseno_vistas.index', compact('views', 'id', 'construccionInmersion', ));
        }
        return view('error404');

    }

    public function create($id, Request $request)
    {
        if (MyFunctions::validar_superadmin() === true) {
            // return $request->all();
            return $this->disenoVistas->create($request->all(), $id);
            
        }
    }

    public function update(Request $request, $id)
    {
        if (MyFunctions::validar_superadmin() === true) {
            return $this->disenoVistas->update($id, $request->all());
        }
    }

    public function destroy($id)
    {
        if (MyFunctions::validar_superadmin() === true) {
            return $this->disenoVistas->delete($id);
        }
    }

    public function changeStatus($id)
    {
        if (MyFunctions::validar_superadmin() === true) {
            return $this->disenoVistas->changeStatus($id);
        }
    }

}