<?php

namespace App\Utils\Constantes\Erp;

class SqlClient
{


    public function getClient($id)
    {
        return "SELECT * FROM erp_grupo_empresarial WHERE erp_grupo_empresarial.id = '$id'";
    }
    public function getClientWithCompanie()
    {
        return "SELECT 
            id, 
            codigo, 
            nit, 
            email,
            descripcion, 
            direccion, 
            telefono, 
            tercero FROM erp_grupo_empresarial;
        ";
    }
    public function getCodigo($data)
    {
        $nit = $data["nit"];
        $telefono = $data["telefono"];
        $direccion = $data["direccion"];
        $codigo = $data["codigo"];


        return "SELECT nit,telefono,direccion, codigo FROM erp_grupo_empresarial WHERE
         (nit='$nit' OR 
          telefono='$telefono' OR 
          direccion='$direccion' OR
          codigo='$codigo')
         ";

    }
    public function getDifferentCode($id, $code)
    {
        return $this->getCodigo($code) . "AND id != " . $id;
    }
    public function sqlGetRelation($id)
    {
        return "
        SELECT * FROM (
             SELECT a.cliente_id id , 'usuario' tipo
            FROM erp_relacion_user_cliente a
            UNION   
            SELECT a.cliente_id id , 'Empresa' tipo
            FROM erp_relacion_empresas a
            UNION  
            SELECT a.id id , 'empresarial' tipo
            FROM erp_grupo_empresarial a 
        ) X where x.id = '$id' GROUP BY 1,2;
        ";
    }

    public function getSqlModulesById($clientsId)
    {
        return "SELECT id FROM erp_grupo_empresarial WHERE id = '$clientsId'";
    }
    public function getIdClientByUser($id)
    {
        return
            "SELECT erp_grupo_empresarial.id FROM erp_relacion_user_cliente 
        LEFT JOIN erp_grupo_empresarial ON erp_relacion_user_cliente.cliente_id = erp_grupo_empresarial.id
        WHERE erp_relacion_user_cliente.user_id = $id;
        ";
    }
    public function findDbByClientById($idClient, $nit)
    {
        return
            "
            SELECT contabilidad_empresas.razon_social
            FROM contabilidad_empresas
            WHERE contabilidad_empresas.nit = '$nit'
       
               OR EXISTS (
                SELECT ge.descripcion as name
                FROM erp_grupo_empresarial ge 
                WHERE ge.nit = '$nit' and ge.id != $idClient
            );
            ";
    }
}