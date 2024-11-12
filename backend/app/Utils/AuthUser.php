<?php

namespace App\Utils;

use App\Data\Models\UsuarioModel;
use Illuminate\Support\Facades\Auth;

class AuthUser
{
    public static function getUsuariosLogin(): UsuarioModel
    {
        $user = Auth::user();
        return new UsuarioModel($user->id, $user->name, $user->email, $user->tipo_administrador, $user->estado, null);
    }
    public static function ValidadRolPorVistaUsuario($userId, $vistaId, $permisoCrudId, $roleId)
    {
        $query = \DB::connection('app')->select(
        "SELECT * FROM  erp_roles_asignado_usuario AS RAU 
        INNER JOIN roles_permiso  AS RP ON RP.roles_id = RAU.role_id 
        INNER JOIN permisos_crud AS PC ON PC.permisos_crud_id = RP.permisos_crud_id
        WHERE RAU.user_id = '$userId' AND RAU.role_id = '$roleId' 
        AND PC.permisos_crud_id = '$permisoCrudId' AND RP.vista_id = '$vistaId'"
        );
        return !empty($query);
    }

}