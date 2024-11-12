<?php

namespace App\Utils\Constantes\NavbarMenus;

use Illuminate\Support\Facades\Auth;

use App\Utils\AuthUser;
use App\Utils\CatchToken;

class ConstantesMenu
{
    public function sqlGetModulosAll()
    {
        $user = Auth::user();

        $tipo_administrador = $user->tipo_administrador;
        $empresaId = "";

        if ($tipo_administrador != 1) {
            $empresaId = CatchToken::Claims();
        }

        $query = "SELECT erp_modulos.id, erp_modulos.descripcion, erp_modulos.logo
              FROM erp_modulos  INNER JOIN `erp_relacion_licencias`  ON  erp_modulos.id = erp_relacion_licencias.modulo_id
              WHERE  activo = '1' AND erp_relacion_licencias.empresa_id = '$empresaId'";

        switch ($tipo_administrador) {
            case 1:
                $query = "SELECT erp_modulos.id, erp_modulos.descripcion, erp_modulos.logo
                FROM erp_modulos WHERE `descripcion` = 'Administrador'";
                break;
            case 2:
                $query = "SELECT erp_modulos.id, erp_modulos.descripcion, erp_modulos.logo
              FROM erp_modulos WHERE tipo_acceso = '2' AND descripcion <> 'Todos'";
                break;
            case 3:
                $query .= " AND tipo_acceso = '3' AND descripcion <> 'Todos'";
                break;
            case 4:
                $query .= " AND erp_modulos.descripcion <> 'Administrador'";
                break;
            default:
                break;
        }

        $query .= " ORDER BY orden";
        return $query;
    }


    public function sqlGetMenuAll()
    {
        return "SELECT
        erp_menuses.id AS menu_id , erp_menuses.descripcion AS menus , erp_menuses.modulo_id AS modulo_id
        FROM erp_menuses WHERE estado = '1' ORDER BY orden";
    }

    public function getSubmenusAll()
    {
        return "SELECT
        erp_sub_menuses.id AS submenu_id , erp_sub_menuses.descripcion as submenus , erp_sub_menuses.menu_id as menu_id
        FROM
        erp_sub_menuses WHERE estado = '1' ORDER BY orden";
    }

    public function getVistaAll()
    {
        return " SELECT 
        erp_vistas.id AS vista_id , erp_vistas.descripcion AS vista , erp_vistas.submenu_id AS submenu_id , erp_vistas.ruta
        FROM
        erp_vistas WHERE estado = '1' ORDER BY orden";
    }

    public function sqlGetModulosUsuario($id)
    {
        return "SELECT c.id , c.descripcion
        FROM USERS A INNER JOIN erp_permisos_modulos b ON a.id = b.user_id
        INNER JOIN erp_modulos c ON b.modulo_id = c.id WHERE a.id = '$id' AND
        c.activo ='1' ORDER BY c.orden";
    }

    public function sqlGetMenuUsuario($id)
    {
        return "SELECT
        d.id AS menu_id , d.descripcion AS menus , c.id AS modulo_id
        FROM USERS A
        INNER JOIN erp_permisos_modulos b ON a.id = b.user_id
        INNER JOIN erp_modulos c ON b.modulo_id = c.id
        INNER JOIN erp_menuses d ON d.modulo_id = c.id
        WHERE a.id = '$id' AND d.estado = '1' ORDER BY d.orden";
    }

    public function getSubmenusUsuario($id)
    {
        return "SELECT
        e.id AS submenu_id , e.descripcion as submenus , d.id as menu_id
        FROM
        USERS A
        INNER JOIN erp_permisos_modulos b ON a.id = b.user_id
        INNER JOIN erp_modulos c ON b.modulo_id = c.id
        INNER JOIN erp_menuses d ON d.modulo_id = c.id
        INNER JOIN erp_sub_menuses e on e.menu_id = d.id
        WHERE a.id = '$id' AND e.estado = '1' ORDER BY e.orden";
    }

    public function getVistaUsuario($id)
    {
        return " SELECT 
        f.id AS vista_id , f.descripcion AS vista , e.id AS submenu_id , f.ruta
        FROM
        USERS A
        INNER JOIN erp_permisos_modulos b ON a.id = b.user_id
        INNER JOIN erp_modulos c ON b.modulo_id = c.id
        INNER JOIN erp_menuses d ON d.modulo_id = c.id
        INNER JOIN erp_sub_menuses e ON e.menu_id = d.id
        INNER JOIN erp_vistas f ON f.submenu_id = e.id
        WHERE a.id = '$id' AND f.estado = '1' ORDER BY f.orden";
    }
    public function getPermissionsModules($id)
    {
        $usuario = AuthUser::getUsuariosLogin();

        return "SELECT * FROM erp_permisos_modulos WHERE user_id= '{$usuario->getId()}' AND modulo_id = '24'";
    }

    
    public function getModulosMain()
    {
        $user = Auth::user();

        if ($user->tipo_administrador) {
            $tipo_administrador = $user->tipo_administrador;
        }

        $id_usuario = $user->id;

        $empresaId = "";

        if ($tipo_administrador != 1) {
            $empresaId = CatchToken::Claims();
        }

        $query = "SELECT erp_modulos.id as id, erp_modulos.ruta, erp_modulos.descripcion descripcion, erp_modulos.logo FROM erp_modulos 
        INNER JOIN `erp_relacion_licencias` ON erp_modulos.id = erp_relacion_licencias.modulo_id 
        INNER JOIN `contabilidad_empresas` ON contabilidad_empresas.id = erp_relacion_licencias.empresa_id 
        WHERE erp_relacion_licencias.empresa_id = '$empresaId'";


        switch ($tipo_administrador) {
            case 1:
                $query = "SELECT erp_modulos.id as id,  erp_modulos.ruta, erp_modulos.descripcion descripcion, erp_modulos.logo
                FROM erp_modulos WHERE `descripcion` = 'Administrador'";
                break;
            case 2:
                $query = "SELECT erp_modulos.id as id, erp_modulos.ruta, erp_modulos.descripcion descripcion, erp_modulos.logo
                FROM erp_modulos WHERE tipo_acceso = '2' AND descripcion <> 'Todos'";
                break;
            case 3:
                $query = "SELECT erp_modulos.id as id, erp_modulos.ruta, erp_modulos.descripcion descripcion, erp_modulos.logo FROM erp_modulos
                INNER JOIN erp_permisos_modulos ON erp_modulos.id = erp_permisos_modulos.modulo_id
                INNER JOIN `erp_relacion_licencias` ON erp_modulos.id = erp_relacion_licencias.modulo_id 
                INNER JOIN `contabilidad_empresas` ON contabilidad_empresas.id = erp_relacion_licencias.empresa_id 
                WHERE erp_relacion_licencias.empresa_id = '$empresaId'";

                $query .= " AND tipo_acceso = '3' AND erp_modulos.descripcion <> 'Todos' AND erp_permisos_modulos.user_id = '$id_usuario'";
                break;
            case 4:
                $query .= " AND erp_modulos.descripcion <> 'Administrador'";
                break;
            default:
                break;
        }
        $query .= " ORDER BY orden";
        return $query;
    }
}
