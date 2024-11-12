<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Erp\RolesRequest;
use App\Models\Roles;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\TransfersData\Erp\Roles\Interfaces\IRoles;
use Exception;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    protected IRoles $_rolesServices;
    public function __construct(IRoles $iRoles)
    {
        $this->_rolesServices = $iRoles;
    }

    public function store(RolesRequest $request)
    {
        $rol = new Roles();
        $rol->descripcion = strtoupper($request->input("descripcion"));
        return $this->_rolesServices->createRole($rol);
    }

    public function show(Request $request)
    {
        return $this->_rolesServices->getRoles($request);
    }

    public function update(RolesRequest $request)
    {
        $id = $request->query("id");
        $id = base64_decode($id);
        $id = EncryptionFunction::StaticDesencriptacion($id);
        $request->validate(["id" => "required", "codigo" => "required"]);
        $rol = new Roles($request->all());
        return $this->_rolesServices->updateRole($id, $rol);
    }

    public function destroy(string $id, Request $request)
    {
        // $id = base64_decode($id);
        // $id = EncryptionFunction::StaticDesencriptacion($id);
        return $this->_rolesServices->deleteRole($id);
    }
}
