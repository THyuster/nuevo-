<?php

namespace App\Utils\Constantes\App\Navbar;

class SqlNavbar
{
    public $connection = "app";

    public function sqlGetModulosByEmpresaId(string $empresaId): string
    {
        return "SELECT
                erp_modulos.id idModulo,
                erp_modulos.ruta,
                erp_modulos.descripcion modulos,
                erp_modulos.logo,
                erp_relacion_licencias.empresa_id
            FROM
                erp_modulos
            INNER JOIN `erp_relacion_licencias` ON erp_modulos.id = erp_relacion_licencias.modulo_id
            INNER JOIN `contabilidad_empresas` ON contabilidad_empresas.id = erp_relacion_licencias.empresa_id
            WHERE
                contabilidad_empresas.id = '$empresaId'";
    }

    public function sqlGetRolesAsigandoByUserId(string $userId): string
    {
        return "SELECT 
            rp.modulo_id, 
            rp.roles_id, 
            u.id AS user_id 
        FROM 
            erp_roles_asignado_usuario erau
            INNER JOIN roles_permiso rp ON rp.roles_id = erau.role_id 
            INNER JOIN erp_modulos em ON em.id = rp.modulo_id
            INNER JOIN users u ON u.id = '$userId' 
        GROUP BY 
            rp.modulo_id, 
            rp.roles_id, 
            u.id";
    }

    public function sqlModulosAsignadoByRoleUser()
    {
        return "SELECT erp_modulos.idModulo as id, erp_modulos.modulos as descripcion, erp_modulos.logo  
        FROM ({$this->sqlGetModulosByEmpresaId("28")}) AS erp_modulos
        INNER JOIN ({$this->sqlGetRolesAsigandoByUserId("249")}) AS asignado_usuario 
        ON asignado_usuario.modulo_id = erp_modulos.idModulo";
    }
    public function sqlVistasAsignadoByRoleUser(string $role_id)
    {
        return "SELECT
                erp_vistas.id AS vista_id , erp_vistas.descripcion AS vista , erp_vistas.submenu_id AS submenu_id , erp_vistas.ruta
            FROM
                erp_vistas 
            INNER JOIN roles_permiso ON erp_vistas.id = roles_permiso.vista_id
            WHERE roles_permiso.roles_id = '$role_id' GROUP BY erp_vistas.id, erp_vistas.descripcion, erp_vistas.submenu_id, erp_vistas.ruta";
    }

    public function getRoleUser(string $user_id)
    {
        return "SELECT * FROM erp_roles_asignado_usuario WHERE user_id = '$user_id'";
    }

    public function getModulosByRole($role_id)
    {
        return "SELECT
            erp_modulos.id, erp_modulos.descripcion, erp_modulos.logo,erp_modulos.ruta
        FROM
        erp_modulos
        INNER JOIN erp_menuses on erp_modulos.id = erp_menuses.modulo_id
        INNER JOIN erp_sub_menuses ON erp_sub_menuses.menu_id = erp_menuses.id
        INNER JOIN erp_vistas ON erp_vistas.submenu_id = erp_sub_menuses.id
        INNER JOIN roles_permiso ON erp_vistas.id = roles_permiso.vista_id
        WHERE roles_permiso.roles_id = '$role_id' GROUP BY erp_modulos.id,erp_modulos.descripcion,erp_modulos.logo, erp_modulos.ruta";
    }

    public function getSubmenusesByRole($role_id)
    {
        return "SELECT
            erp_sub_menuses.id AS submenu_id , erp_sub_menuses.descripcion as submenus , erp_sub_menuses.menu_id as menu_id
            FROM
                erp_modulos
            INNER JOIN erp_menuses ON erp_modulos.id = erp_menuses.modulo_id
            INNER JOIN erp_sub_menuses ON erp_sub_menuses.menu_id = erp_menuses.id
            INNER JOIN erp_vistas ON erp_vistas.submenu_id = erp_sub_menuses.id
            INNER JOIN roles_permiso ON erp_vistas.id = roles_permiso.vista_id
            WHERE
                roles_permiso.roles_id = '$role_id'
            GROUP BY erp_sub_menuses.id, erp_sub_menuses.descripcion, erp_sub_menuses.menu_id";
    }


    public function getMenusByRole($role_id)
    {
        return "SELECT
            erp_menuses.id AS menu_id , erp_menuses.descripcion AS menus , erp_menuses.modulo_id AS modulo_id
        FROM
            erp_modulos
        INNER JOIN erp_menuses ON erp_modulos.id = erp_menuses.modulo_id
        INNER JOIN erp_sub_menuses ON erp_sub_menuses.menu_id = erp_menuses.id
        INNER JOIN erp_vistas ON erp_vistas.submenu_id = erp_sub_menuses.id
        INNER JOIN roles_permiso ON erp_vistas.id = roles_permiso.vista_id
        WHERE
            roles_permiso.roles_id = '$role_id'
        GROUP BY erp_menuses.id, erp_menuses.descripcion, erp_menuses.modulo_id";
    }

}
