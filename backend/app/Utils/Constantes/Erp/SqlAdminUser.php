<?php

namespace App\Utils\Constantes\Erp;

class SqlAdminUser
{
    private $nameDataBase = "users";
    private $nameDataBaseRelations = " erp_relacion_user_cliente";



    public function getSqlDataUsersByCompanie($id)
    {
        return "

            SELECT
            users.id, 
            users.name, 
            users.email, 
            users.estado as 'stateUser', 
            contabilidad_empresas.id as 'companieId', 
            contabilidad_empresas.razon_social as 'razonSocial',
            erp_relacion_user_empresas.estado as 'stateCompanie',
            erp_relacion_user_empresas.id as 'idRelation'
             FROM erp_relacion_empresas 
            LEFT JOIN contabilidad_empresas ON 
            erp_relacion_empresas.empresa_id = contabilidad_empresas.id 
            LEFT JOIN erp_relacion_user_empresas ON 
            erp_relacion_user_empresas.empresa_id = erp_relacion_empresas.empresa_id 
            LEFT JOIN users ON users.id = erp_relacion_user_empresas.user_id 
            WHERE erp_relacion_empresas.cliente_id= $id 
            AND users.tipo_administrador= 4;

        ";
    }
    public function getSqlDataUsersT4T3ByCompanie($id)
    {
        return
            "
            SELECT
            SUM(CASE WHEN users.tipo_administrador = 4 THEN 1 ELSE 0 END) AS 'admins',
            SUM(CASE WHEN users.tipo_administrador = 3 THEN 1 ELSE 0 END) AS 'users'
            FROM
            users
            LEFT JOIN erp_relacion_user_empresas ON erp_relacion_user_empresas.user_id = users.id
             WHERE
            users.tipo_administrador IN (3, 4)
            AND erp_relacion_user_empresas.empresa_id = $id;
        ";
    }


    public function getSqlNumberUsersByCompanie($id)
    {
        return
            "
            SELECT 
            (
                SELECT COUNT(*) FROM erp_relacion_user_empresas WHERE empresa_id =  $id
                AND erp_relacion_user_empresas.estado = 1
            ) AS 'cantUsers',
            contabilidad_empresas.razon_social AS 'companie'
            FROM contabilidad_empresas
            WHERE contabilidad_empresas.id = $id;
        
            ";
    }
    public function getSqlNumberQuotaByCompanie($id)
    {
        return
            "
            SELECT 
            AVG(erp_relacion_licencias.cantidad_usuarios) as 'quotaByCompanie' 
            FROM
            erp_relacion_licencias
            WHERE erp_relacion_licencias.empresa_id = $id;
        ";
    }

    public function getSqlDeleteRelation($idAdmin)
    {
        return "
            DELETE
            FROM
            erp_relacion_user_empresas
            WHERE erp_relacion_user_empresas.user_id = $idAdmin
        ";
    }
    public function getSqlRelation($id)
    {
        return
            "SELECT
            erp_relacion_user_empresas.empresa_id as empresaId,
             erp_relacion_user_empresas.estado 
            FROM erp_relacion_user_empresas 
            WHERE erp_relacion_user_empresas.id= $id
            ";

    }

    public function sqlGetCompaniesId($idAdmin)
    {
        return " SELECT erp_relacion_user_empresas.empresa_id as 'id' 
        FROM erp_relacion_user_empresas WHERE erp_relacion_user_empresas.user_id =$idAdmin";
    }
    public function sqlDeleteCompaniesId($idAdmin, $deleteIds)
    {
        return
            "
            UPDATE erp_relacion_user_empresas SET estado=0
        WHERE erp_relacion_user_empresas.user_id =$idAdmin AND
     erp_relacion_user_empresas.empresa_id IN ($deleteIds);
        ";
    }
    public function sqlgetCompaniesByUser($idUser)
    {
        return
            "SELECT contabilidad_empresas.id as 'companieId', 
            contabilidad_empresas.razon_social as 'razonSocial',
            contabilidad_empresas.ruta_imagen as 'image'
            FROM erp_relacion_user_empresas 
            JOIN contabilidad_empresas 
            ON contabilidad_empresas.id = erp_relacion_user_empresas.empresa_id
             WHERE erp_relacion_user_empresas.user_id = '$idUser' AND erp_relacion_user_empresas.estado <> '0'
        ";
    }
}