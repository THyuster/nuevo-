<?php

namespace App\Http\Controllers\modulo_administradores\gestion_roles;

use App\Http\Controllers\Controller;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\TransfersData\modulo_administradores\gestionRoles\IGestionRoles;
use Illuminate\Http\Request;

class gestionRolesController extends Controller
{
    private IGestionRoles $_iGestionRoles;
    private EncryptionFunction $_encriptacion;
    public function __construct(IGestionRoles $iGestionRoles, EncryptionFunction $encryptionFunction)
    {
        $this->_iGestionRoles = $iGestionRoles;
        $this->_encriptacion = $encryptionFunction;
    }
    public function crear_rol(Request $request)
    {
        $entidad_rol = $request->all();
        $entidad_rol["empresa"] = $this->_encriptacion->Desencriptacion($request->cookie("empresa"));
        return $this->_iGestionRoles->crearRol($entidad_rol);
    }

    public function get_roles(Request $request)
    {
        $empresa = $this->_encriptacion->Desencriptacion($request->cookie("empresa"));
        return $this->_iGestionRoles->obtenerRol($empresa);
    }

    public function eliminar_roles(Request $request, $id)
    {
        $empresa = $this->_encriptacion->Desencriptacion($request->cookie("empresa"));
        return $this->_iGestionRoles->eliminarRol($id, $empresa);
    }

    public function modificar_roles(Request $request,$id){
        $empresa = $this->_encriptacion->Desencriptacion($request->cookie("empresa"));
        $request["empresa"] = $empresa;
        return $this->_iGestionRoles->actualizarRol($request->all(),$id);
    }

    public function activacion_roles($id, Request $request)
    {
        $empresa = $this->_encriptacion->Desencriptacion($request->cookie("empresa"));
        return $this->_iGestionRoles->activacionRol($id, $empresa);
    }

}