<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\DB\tablas;
use App\Utils\TransfersData\ModuloConfiguracion\ServicioAsignacionRoles;
use Illuminate\Http\Request;

class AsignacionRolesController extends Controller
{

    
    private ServicioAsignacionRoles $servicioAsignacionRoles;

    public function __construct() {
        
        $this->servicioAsignacionRoles = new ServicioAsignacionRoles;

    }

    public function getAsignacionRoles()
    {
        return $this->servicioAsignacionRoles->getAsignacionRoles();
    }

  


    public function crear(Request $request)
    {   
        return $this->servicioAsignacionRoles->create($request->all());
    }

    public function roles(Request $request)
    {   
        return $this->servicioAsignacionRoles->obtenerRoles();
    }

    public function update($id, Request $request)
    {
        //
    }

    public function destroy($id)
    {
        return $this->servicioAsignacionRoles->delete($id);
    }
}