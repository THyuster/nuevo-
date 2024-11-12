<?php

namespace App\Utils\Constantes\Erp;

class SqlRoleAssignment
{
    public function findAssignmentByCompanieUserRole($data)
    {
        $userId = $data["userId"];
        $companieId = $data["companieId"];
        $roleId = $data["roleId"];

        return "SELECT id FROM erp_permisos_roles 
        WHERE user_id= $userId AND
        rol_id = $roleId AND 
        empresa_id= $companieId";
    }
    public function findAssignmentByCompanieId($empresaId, $rolId)
    {
        return "SELECT id FROM  erp_roles WHERE erp_roles.empresa_id = $empresaId
        AND erp_roles.id =$rolId ";
    }
    public function getAssignmentUserByCompanie($empresaId)
    {
        return
            "
        SELECT
        users.id as 'usuarioId',
        users.name,
        contabilidad_empresas.id as 'empresaId',
        contabilidad_empresas.razon_social as 'empresa',
        erp_roles.id as 'rolId',
        erp_roles.descripcion as 'rol',
        erp_permisos_roles.estado
        FROM erp_permisos_roles
        LEFT JOIN contabilidad_empresas ON 
        contabilidad_empresas.id = erp_permisos_roles.empresa_id
        LEFT JOIN erp_roles ON
        erp_roles.id = erp_permisos_roles.rol_id
        LEFT JOIN users ON
        users.id = erp_permisos_roles.user_id
        WHERE erp_permisos_roles.empresa_id= $empresaId
        ";
    }

}