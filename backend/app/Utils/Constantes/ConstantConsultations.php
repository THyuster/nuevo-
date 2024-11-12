<?php

namespace App\Utils\Constantes;

class ConstantConsultations
{
    private $sqlModulosAdministrador = "SELECT erp_permisos_modulos.id, users.name, erp_permisos_modulos.modulo, erp_permisos_modulos.estado, users.id as users_id FROM erp_permisos_modulos INNER JOIN users WHERE users.id <> 0 and users.id = erp_permisos_modulos.user_id ORDER BY users.name, erp_permisos_modulos.modulo";

    private $sqlGetModulosSinTodos = "SELECT * FROM `erp_modulos` WHERE erp_modulos.descripcion <> 'Todos'";

    private $sqlModulosSinAdministrador = "SELECT erp_permisos_modulos.id, users.name, erp_permisos_modulos.modulo, erp_permisos_modulos.estado, users.id as users_id
    FROM erp_permisos_modulos
    LEFT JOIN users ON users.id = erp_permisos_modulos.user_id
    WHERE users.id =='0'";

    private $sqlUsersActive = "SELECT users.id, users.name, users.estado  FROM `users` WHERE users.estado = 'ACTIVO'";

    private $sqlFindModule = "SELECT * FROM erp_modulos WHERE descripcion = ";

    private $sqlCheckUserExist = "SELECT * FROM users WHERE id =";

    private $sqlInsertModulos = "INSERT INTO erp_permisos_modulos (user_id, modulo, modulo_id, estado)
    VALUES ";

    private $sqldeleteModulo = "DELETE FROM erp_permisos_modulos WHERE user_id =";

    //    private $deleteByIdUserAndModuleName= "DELETE FROM erp_permisos_modulos WHERE user_id = :idUsuario AND modulo <> :moduloName";
    private $sqlUpdateModule = "UPDATE erp_permisos_modulos SET modulo =";

    private $sqlDeleteByModuleAndName = "DELETE FROM erp_permisos_modulos WHERE user_id =";

    private $sqlGetMigraciones = "SELECT * FROM erp_migraciones order by id desc";


    private $sqlUpdateFields = "";

    public function getSqlDeleteModulo($jsonData)
    {
        return $this->sqldeleteModulo . "'{$jsonData['idUsuario']}' AND modulo != '{$jsonData['Modulo']}'";
    }
    function getSqlInsertModulos($jsonData)
    {
        return $this->sqlInsertModulos . "('{$jsonData['idUsuario']}', '{$jsonData['Modulo']}', '{$jsonData['idModulo']}', 'ACTIVO')";
    }

    function getSqlAdmin()
    {
        return $this->sqlModulosAdministrador;
    }

    function getSqlNotAdmin()
    {
        return $this->sqlModulosSinAdministrador;
    }

    function getUserActive()
    {
        return $this->sqlUsersActive;
    }
    function getModule($modulo)
    {
        return $this->sqlFindModule . "'$modulo'";
    }
    function getSqlCheckUserExist($user_id)
    {
        return $this->sqlCheckUserExist . "'$user_id'";
    }

    function getUpdateModuleByName($IdUsuario, $moduleName, $moduleId)
    {
        return $this->sqlUpdateModule . " '" . $moduleName . "', modulo_id = " . $moduleId . ", 
                                 estado = 'ACTIVO'
                                 WHERE user_id = " . $IdUsuario . "
                                 LIMIT 1";
    }

    function getDeleteNameAndModule($idUsuario, $moduloName)
    {
        return $this->sqlDeleteByModuleAndName . "'" . $idUsuario . "' AND modulo <> '" . $moduloName . "'";
    }

    function getSqlDeleteModuleAndName($idUsuario, $moduloName)
    {
        return $this->sqldeleteModulo . "$idUsuario AND modulo <> '$moduloName'";
    }

    function getSqlUpdateModuleByName($idUsuario, $moduloName, $idModulo, $previos)
    {
        $currentDate = date('Y-m-d h:i:s');
        return "UPDATE erp_permisos_modulos
        SET modulo = '" . $moduloName . "',
            modulo_id = '" . $idModulo . "',
            updated_at='" . $currentDate . "',
            estado = 'ACTIVO'
             WHERE user_id = '" . $idUsuario . "' and
             modulo = '" . $previos . "'
        ";
    }

    function getModulosSinTodos()
    {
        return $this->sqlGetModulosSinTodos;
    }

    /* MODULO : CONFIGURACION +++ MENU : NAVBAR +++ SUBMENU : ESTRUCTURA */
    /* SUBMENU : DISEÑO MENU */
    function getMigraciones()
    {
        return $this->sqlGetMigraciones;
    }
    function getSqlRelacionUser($idUser)
    {
        return
            "
       SELECT erp_permisos_modulos.user_id FROM erp_permisos_modulos WHERE erp_permisos_modulos.user_id= $idUser
       ";
    }

    public function sqlPermisosPorId($idAdmin)
    {
        return " SELECT erp_permisos_modulos.modulo_id as 'id' 
        FROM erp_permisos_modulos WHERE erp_permisos_modulos.user_id =$idAdmin";
    }
    public function sqlEliminarModulosPorId($idAdmin, $deleteIds)
    {
        return "DELETE  FROM erp_permisos_modulos 
        WHERE erp_permisos_modulos.user_id =$idAdmin AND
     erp_permisos_modulos.modulo_id IN ($deleteIds)";
    }
    public function sqlObtenerModulosPorLicencia($empresaId)
    {
        return "  SELECT erp_modulos.id, erp_modulos.descripcion FROM erp_relacion_licencias  
        LEFT JOIN erp_modulos ON
        erp_relacion_licencias.modulo_id = erp_modulos.id
        WHERE erp_relacion_licencias.empresa_id=$empresaId";
    }
    public function sqlObtenerModulosPorLicenciaYEmprasa($empresaId, $idsModulos)
    {
        return "
        SELECT  erp_relacion_licencias.modulo_id as id FROM erp_relacion_licencias 
        WHERE erp_relacion_licencias.empresa_id=$empresaId AND
        erp_relacion_licencias.modulo_id IN ($idsModulos)";
    }
    public function sqlObtenerTipoTable()
    {
        return " SELECT 
            tipo_tabla.id,
            tipo_tabla.tipo
            FROM tabla_control  
            LEFT JOIN tipo_tabla ON 
            tipo_tabla.id = tabla_control.tipo_tabla
            WHERE tabla_control.nombre_tabla = ?";
    }

    public static function sqlObtenerTipoTableStatic()
    {
        return "SELECT 
            tipo_tabla.id,
            tipo_tabla.tipo
            FROM tabla_control  
            LEFT JOIN tipo_tabla ON 
            tipo_tabla.id = tabla_control.tipo_tabla
            WHERE tabla_control.nombre_tabla = ?";
    }


    public function sqlValidarModuloSinRolAsignado($userId, $moduloId)
    {
        return
            "
            SELECT  emodulos.id moduloId
            FROM erp_roles_asignado_usuario erau 
            LEFT JOIN roles_permiso rp ON rp.roles_id = erau.role_id
            LEFT JOIN erp_vistas ev ON ev.id = rp.vista_id
            LEFT JOIN erp_sub_menuses esm ON esm.id = ev.submenu_id
            LEFT JOIN erp_menuses emenuses ON emenuses.id =esm.menu_id
            LEFT JOIN erp_modulos emodulos ON emodulos.id = emenuses.modulo_id

            WHERE erau.user_id = $userId and emodulos.id= $moduloId
            GROUP BY 1;
        ";
    }
}
