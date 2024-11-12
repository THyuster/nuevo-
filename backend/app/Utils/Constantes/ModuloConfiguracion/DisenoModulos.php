<?php

namespace App\Utils\Constantes\ModuloConfiguracion;

class DisenoModulos
{
    private $sqlInsertModule = 'INSERT INTO erp_modulos (codigo, descripcion, ruta, orden, activo) VALUES ';
    private $sqlGetModule = 'SELECT * FROM erp_modulos WHERE descripcion = ';

    public function sqlcreateModules($jsonData)
    {
        return $this->sqlInsertModule . "('{$jsonData["codigo"]}', '{$jsonData["descripcion"]}',
            '{$jsonData["ruta"]}', '{$jsonData["orden"]}', '{$jsonData["activo"]}'
        )";
    }

    public function sqlGetByModule($module)
    {
        return $this->sqlGetModule . "'$module'";
    }

    public function updateSqlDisenoModulos($descripcion, $ubicacion, $orden, $tipo_acceso, $logo, $id)
    {
        return " UPDATE erp_modulos SET `descripcion` = '$descripcion', 
        `ruta` = '$ubicacion', `orden` = $orden, `tipo_acceso`='$tipo_acceso', `logo` = '$logo' WHERE 
        `id` = '$id' ";
    }

    public function updateSqlEstadoDisenoModulos($estado, $id)
    {
        return "UPDATE erp_modulos SET `activo` = $estado WHERE `id` = '$id'";
    }

    public function verificacionSqlModuloNavegacion($codigo, $ubicacion, $orden, $id, $descripcion)
    {
        return "SELECT * FROM erp_modulos WHERE codigo = '" . $codigo . "' AND ruta = 
        '" . $ubicacion . "' AND orden = " . $orden . ' AND id = ' . $id . " AND descripcion = '" . $descripcion . "'";
    }

    public function verificacionSatusBefore($codigo, $ubicacion, $orden, $id, $descripcion)
    {
        return "SELECT * FROM erp_modulos WHERE codigo = 
        '" . $codigo . "' AND ruta = '" . $ubicacion . "' AND orden = " . $orden . '
         AND id = ' . $id . " AND descripcion = '" . $descripcion . "'";
    }

    public function verficicacionExistente($ubicacion, $orden, $descripcion)
    {
        return $sql = "SELECT * FROM erp_modulos WHERE 
        ruta = '" . $ubicacion . "' AND orden = " . $orden . " AND descripcion = '" . $descripcion . "'";
    }

    public function sqlGetModules()
    {
        return "SELECT * FROM erp_modulos WHERE codigo NOT IN ('M101', 'M24')";
    }

    public function sqlValidarModuloNoTengaRol($userId, $rolId)
    {
        return "SELECT 
            emodulos.id modulosId, 
            emodulos.descripcion modulos
            FROM erp_roles ep
            LEFT JOIN roles_permiso erv ON erv.roles_id = ep.id
            LEFT JOIN erp_vistas ev ON ev.id = erv.vista_id
            LEFT JOIN erp_sub_menuses esm ON esm.id =ev.submenu_id
            LEFT JOIN erp_menuses em ON em.id = esm.menu_id
            LEFT JOIN erp_modulos emodulos ON emodulos.id = em.modulo_id
            INNER JOIN (
                    SELECT epm.modulo_id moduloId
                    FROM erp_permisos_modulos epm 
                    WHERE  epm.user_id = '$userId'
                ) as x on emodulos.id = x.moduloId
            WHERE ep.id= '$rolId'";
    }

    public function sqlObtenerModuloDelRol($rolId)
    {
        return "SELECT 
            emodulos.id  modulosId,
            emodulos.descripcion modulos
            FROM erp_roles ep
            LEFT JOIN roles_permiso erv ON erv.roles_id = ep.id
            LEFT JOIN erp_vistas ev ON ev.id = erv.vista_id
            LEFT JOIN erp_sub_menuses esm ON esm.id =ev.submenu_id
            LEFT JOIN erp_menuses em ON em.id = esm.menu_id
            LEFT JOIN erp_modulos emodulos ON emodulos.id = em.modulo_id
            WHERE ep.id= '$rolId'";
    }
}
