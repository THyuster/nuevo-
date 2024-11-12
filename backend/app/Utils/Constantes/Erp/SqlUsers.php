<?php

namespace App\Utils\Constantes\Erp;

class SqlUsers
{


    public function getSqlDataUsers($empresaId)
    {
        return
            "
        SELECT 
        users.id,
        users.name ,
        users.email,
        users.estado,
        tp.id idTipoCargo,
        tp.tipo tipo_cargo
        FROM users
        LEFT JOIN erp_relacion_user_empresas ON
        erp_relacion_user_empresas.user_id = users.id
        LEFT JOIN tipo_cargo tp   ON  users.tipo_cargo= tp.id
        WHERE users.tipo_administrador = 3 AND erp_relacion_user_empresas.empresa_id = $empresaId;
        ";
    }

    public function getSqlDataUsersPermisos($empresaId)
    {
        return "SELECT  erp_permisos_modulos.id, users.name, erp_permisos_modulos.modulo, erp_permisos_modulos.estado, users.id as users_id
        FROM users
        INNER JOIN erp_relacion_user_empresas ON
        erp_relacion_user_empresas.user_id = users.id INNER JOIN erp_permisos_modulos ON users.id = erp_permisos_modulos.user_id
        WHERE users.tipo_administrador = '3' AND erp_relacion_user_empresas.empresa_id = '$empresaId'";
    }

    public function deleteRelationClientCompanie($id)
    {
        return "DELETE ere FROM erp_relacion_user_cliente erc JOIN erp_relacion_user_empresas ere ON erc.user_id = ere.user_id WHERE erc.user_id = $id";
    }

    public function deleteRelationsCompanie($idUser)
    {
        return "DELETE FROM erp_relacion_user_empresas WHERE erp_relacion_user_empresas.user_id = $idUser";
    }
    public function updateRelationsCompanie($idCompanies, $idAdmin)
    {
        return
            "UPDATE  erp_relacion_user_empresas
        SET erp_relacion_user_empresas.empresa_id= $idCompanies
        WHERE  erp_relacion_user_empresas.user_id =$idAdmin";
    }
    public function sqlFindEmail($email)
    {
        return "SELECT users.id FROM users WHERE users.email = " . "'$email'";
    }
    public function sqlRelationUserClient($id)
    {
        return "SELECT erp_relacion_user_cliente.cliente_id clienteId FROM 
        erp_relacion_user_cliente 
        WHERE erp_relacion_user_cliente.user_id = $id";
    }
    public function sqlGetUserClient($userId, $empresaId)
    {
        return
            "
            SELECT erp_relacion_user_empresas.id clienteId FROM 
            erp_relacion_user_empresas 
            WHERE erp_relacion_user_empresas.user_id = $userId AND erp_relacion_user_empresas.empresa_id = $empresaId
        ";
    }
}
