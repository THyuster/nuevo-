<?php

namespace App\Utils\Constantes\ModuloContabilidad;

class SqlCompanies
{

    public function getSqlCompanieAndRelationThird()
    {
        return "SELECT contabilidad_empresas.id , 
        contabilidad_empresas.nit,
        contabilidad_empresas.razon_social,
        contabilidad_empresas.tercero,
        contabilidad_empresas.razon_social as 'Empresa', 
        CONCAT(erp_grupo_empresarial.id, '-', erp_grupo_empresarial.descripcion) as cliente_id,
        contabilidad_empresas.direccion , 
        contabilidad_empresas.telefono,
        contabilidad_empresas.email, contabilidad_empresas.estado
        FROM contabilidad_empresas 
        LEFT JOIN erp_relacion_empresas ON erp_relacion_empresas.empresa_id= contabilidad_empresas.id 
        LEFT JOIN erp_grupo_empresarial ON erp_grupo_empresarial.id= erp_relacion_empresas.cliente_id";

        //return "
        //SELECT contabilidad_empresas.id , 
        //contabilidad_empresas.razon_social,
        //contabilidad_empresas.razon_social as 'Empresa', 
        //erp_grupo_empresarial.descripcion as 'grupoEmpresarial', 
        //contabilidad_empresas.direccion , 
        //contabilidad_empresas.telefono,
        //contabilidad_empresas.email, contabilidad_empresas.estado, 
        //contabilidad_terceros.identificacion as 'nit', 
        //CONCAT(contabilidad_empresas.tercero_id, ' - ', contabilidad_terceros.identificacion, '-', contabilidad_terceros.nombre_completo) AS 'tercero_id' 
        //FROM contabilidad_empresas 
        //LEFT JOIN contabilidad_terceros ON contabilidad_terceros.id= contabilidad_empresas.tercero_id 
        //LEFT JOIN erp_relacion_empresas ON erp_relacion_empresas.empresa_id= contabilidad_empresas.id 
        //LEFT JOIN erp_grupo_empresarial ON erp_grupo_empresarial.id= erp_relacion_empresas.cliente_id
        //";
    }
    public function getSqlCheckData($field, $value)
    {
        $value = str_replace("'", "''", $value);
        return "SELECT empresa.id FROM contabilidad_empresas empresa WHERE empresa.$field =  '$value' ";
    }

    public function getCompanie($id)
    {
        return "SELECT * FROM contabilidad_empresas empresa WHERE empresa.id = '$id'";
    }

    public function checkExistingRecordExcludingId($id, $field, $value)
    {
        $query = $this->getSqlCheckData($field, $value);

        return $query . " AND empresa.id != '$id'";
    }

    public function findByIds($idClient, $arraysId)
    {

        return
            "
            SELECT erp_relacion_empresas.empresa_id as 'id'
            FROM erp_relacion_empresas 
            WHERE erp_relacion_empresas.cliente_id = $idClient
            AND erp_relacion_empresas.empresa_id IN ($arraysId);
        ";
        // return
        //     " SELECT id FROM contabilidad_empresas WHERE contabilidad_empresas.id  IN ($arraysId)";
    }
    public function sqlDeleteRelationUserCompanie($useId)
    {
        return
            "
            DELETE FROM erp_relacion_user_empresas
            WHERE erp_relacion_user_empresas.user_id = $useId
            
            ";
    }
    public function sqlDeleteRelationUserClient($useId)
    {
        return
            "
            DELETE FROM erp_relacion_user_cliente
            WHERE erp_relacion_user_cliente.user_id = $useId
            ";
    }

    public function findRelationClientCompanie($clientId)
    {
        return "SELECT * FROM erp_relacion_empresas WHERE erp_relacion_empresas.cliente_id = $clientId";
    }
    public function findDbByCompanie($nit)
    {
        return
            "
            SELECT contabilidad_empresas.razon_social 
            FROM contabilidad_empresas WHERE contabilidad_empresas.nit = '$nit'
            OR EXISTS ( SELECT ge.descripcion as name FROM erp_grupo_empresarial ge WHERE ge.nit = '$nit' )";
    }
    public function findDbByCompanieById($idEmpresa, $nit)
    {
        return
            "
            SELECT contabilidad_empresas.razon_social
            FROM contabilidad_empresas
            WHERE contabilidad_empresas.nit = '$nit'
              AND contabilidad_empresas.id != $idEmpresa
               OR EXISTS (
                SELECT ge.descripcion as name
                FROM erp_grupo_empresarial ge
                WHERE ge.nit = '$nit'
            );
            ";
    }

}