<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\App\Navbar\SqlNavbar;
use Illuminate\Http\Request;
use App\Utils\Auth\AuthFilter;
use App\Utils\TransfersData\ModuloConfiguracion\ConsultasModulos;
use App\Utils\Constantes\NavbarMenus\ConstantesMenu;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Support\Facades\Auth;
use stdClass;

class erp_navbarController extends Controller
{

    protected $constantesMenu;
    protected $consult;
    protected $auth;
    protected $crud;

    protected $sqlNavbar;

    public function __construct()
    {
        $this->constantesMenu = new ConstantesMenu;
        $this->consult = new ConsultasModulos;
        $this->auth = new AuthFilter;
        $this->crud = new RepositoryDynamicsCrud;
        $this->sqlNavbar = new SqlNavbar();
    }

    public function UsuariosModulos()
    {
        $DatosUser = $this->auth->UserData();
        $modulosByRole = array();
        $userId = auth()->user()->id;
        $rolesUsuario = $this->crud->sqlFunction($this->sqlNavbar->getRoleUser($userId));

        if (!empty($rolesUsuario)) {
            $modulosByRole = $this->crud->sqlFunction($this->sqlNavbar->getModulosByRole($rolesUsuario[0]->role_id));
        }

        if ($this->auth->Check() && ($DatosUser->estado == 'ACTIVO')) {
            $datos = $this->crud->sqlFunction($this->constantesMenu->getModulosMain());
            $datos = array_merge($datos, $modulosByRole);
            return $datos;
        }

    }

    /* Esta función verifica los permisos de un usuario autenticado 
    para acceder a un módulo específico (identificado por el modulo_id). 
    Si el usuario tiene permisos, se llama a un método para obtener todos los módulos,
    menús y submenús relacionados. Si el usuario no tiene permisos, 
    se llama a otro método para obtener los módulos, menús y submenús correspondientes a un ID específico (en este caso, 10).*/
    public function autoConstruccionNavbar()
    {
        return $this->getAllModulesMenusSubMenusesViwes();
    }
    /*Esta función crea un objeto stdClass con dos atributos: modulos y ruta. 
    Luego, se crea un array que contiene el objeto $objecResponse y se devuelve 
    este array como resultado. La función se utiliza para encapsular 
    una respuesta en un objeto con atributos específicos antes de devolverla.*/
    private function createResponse(string $response, string $ruta)
    {
        $objecResponse = new stdClass();
        $objecResponse->modulos = $response;
        $objecResponse->ruta = $ruta;
        return array($objecResponse);
    }

    /*Esta función toma un array multidimensional de datos 
    y los organiza en una estructura jerárquica que representa los módulos, 
    menús, submenús y vistas. Cada nivel de la jerarquía contiene información relevante
    y se ajusta según las relaciones establecidas en los datos de entrada. 
    El resultado final es un array numérico con la estructura de los módulos 
    y sus menús correspondientes.*/
    private function construccion($data)
    {

        $modulos = array();
        $submenus = array();
        $vistas = array();
        $menus = array();

        // return $data;
        foreach ($data[0] as $modulo) {
            $modulos[$modulo['id']] = array(
                'id' => $modulo['id'],
                'logo' => $modulo['logo'],
                'nombre_modulo' => $modulo['descripcion'],
                'menu' => array()
            );
        }

        foreach ($data[1] as $menu) {
            $menu_id = $menu['menu_id'];

            if (!isset($menus[$menu_id])) {
                $menus[$menu_id] = array(
                    'menus' => $menu['menus'],
                    'modulo_id' => $menu['modulo_id'],
                    'submenus' => array()
                );
            }
        }

        foreach ($data[2] as $vista) {
            $submenu_id = $vista['submenu_id'];

            if (!isset($vistas[$submenu_id])) {
                $vistas[$submenu_id] = array();
            }

            $vistas[$submenu_id][] = array(
                'id' => $vista['vista_id'],
                'descripcion_vista' => $vista['vista'],
                'ruta_vista' => $vista['ruta']
            );
        }

        foreach ($data[3] as $submenu) {
            $menu_id = $submenu['menu_id'];

            if (!isset($submenus[$menu_id])) {
                $submenus[$menu_id] = array();
            }

            $submenus[$menu_id][] = array(
                'submenu_id' => $submenu['submenu_id'],
                'descripcion_submenu' => $submenu['submenus'],
                'vistas' => isset($vistas[$submenu['submenu_id']]) ? $vistas[$submenu['submenu_id']] : array()
            );
        }

        // foreach($data[])

        foreach ($menus as $menu_id => $menu) {
            $menus[$menu_id]['submenus'] = isset($submenus[$menu_id]) ? $submenus[$menu_id] : array();
        }

        foreach ($modulos as $modulo_id => $modulo) {
            foreach ($menus as $menu) {
                if ($menu['modulo_id'] == $modulo_id) {
                    $modulos[$modulo_id]['menu'][] = $menu;
                }
            }
        }
        return array_values($modulos);
    }

    /*Esta función obtiene datos de diferentes tablas de la base de datos
    utilizando métodos de consulta específicos y luego organiza 
    esos datos en una estructura jerárquica llamando a la función construccion().
    El resultado final es un array numérico que representa los módulos, menús, submenús y vistas.*/
    private function getAllModulesMenusSubMenusesViwes()
    {
        $data = array();
        $construccionByRoles = array(); 
        
        $modulosData = $this->crud->sqlFunction($this->constantesMenu->getModulosMain());
        $menusData = $this->crud->sqlFunction($this->constantesMenu->sqlGetMenuAll());
        $vistaData = $this->crud->sqlFunction($this->constantesMenu->getVistaAll());
        $submenusData = $this->crud->sqlFunction($this->constantesMenu->getSubmenusAll());

        $userId = auth()->user()->id;
        $rolesUsuario = $this->crud->sqlFunction($this->sqlNavbar->getRoleUser($userId));
        // $rolesUsuario = [];

        if (!empty($rolesUsuario)) {
            $dataByRole = array();
            $vistasByRole = $this->crud->sqlFunction($this->sqlNavbar->sqlVistasAsignadoByRoleUser($rolesUsuario[0]->role_id));
            $modulosByRole = $this->crud->sqlFunction($this->sqlNavbar->getModulosByRole($rolesUsuario[0]->role_id));
            $menusByRole = $this->crud->sqlFunction($this->sqlNavbar->getMenusByRole($rolesUsuario[0]->role_id));
            $submenusByRole = $this->crud->sqlFunction($this->sqlNavbar->getSubmenusesByRole($rolesUsuario[0]->role_id));
            array_push($dataByRole, $modulosByRole, $menusByRole, $vistasByRole, $submenusByRole);
            $dataByRole = json_decode(json_encode($dataByRole), true);
            $construccionByRoles = $this->construccion($dataByRole);
        }
        array_push($data, $modulosData, $menusData, $vistaData, $submenusData);

        $data = json_decode(json_encode($data), true);
        $data = $this->construccion($data);

      

        return array_merge($construccionByRoles, $data);
    }


    /*Esta función obtiene datos de diferentes tablas de la base de datos
    utilizando métodos de consulta específicos y luego organiza 
    esos datos en una estructura jerárquica llamando a la función construccion().
    El resultado final es un array numérico que representa los módulos, menús, submenús y vistas.*/
    private function getModulesMenusSubMenusesViwesId($id)
    {
        $data = array();
        $modulosData = $this->crud->sqlFunction($this->constantesMenu->sqlGetModulosUsuario($id));
        $menusData = $this->crud->sqlFunction($this->constantesMenu->sqlGetMenuUsuario($id));
        $vistaData = $this->crud->sqlFunction($this->constantesMenu->getVistaUsuario($id));
        $submenusData = $this->crud->sqlFunction($this->constantesMenu->getSubmenusUsuario($id));

        array_push($data, $modulosData, $menusData, $vistaData, $submenusData);
        $data = json_decode(json_encode($data), true);
        return $this->construccion($data);
    }
}