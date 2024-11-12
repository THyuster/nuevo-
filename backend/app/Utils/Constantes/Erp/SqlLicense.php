<?php

namespace App\Utils\Constantes\Erp;

class SqlLicense
{


    public function getLicense($id)
    {
        return "SELECT * FROM erp_licenciamientos WHERE erp_licenciamientos.id = '$id'";
    }
    public function getSqlDeleteAllById($id)
    {
        return "DELETE FROM erp_relacion_licencias WHERE licencia_id ='$id'";
    }

    public function getSqlCheckRelation($idCompanie, $idClient)
    {

        return "SELECT * FROM erp_relacion_empresas relacion WHERE relacion.empresa_id ='$idCompanie' AND relacion.cliente_id='$idClient'";
    }
    public function getRelationIndex()
    {
        return "SELECT DISTINCT licencia.* , 
        relacion_licencia.cantidad_usuarios 'Capacidad usuarios',
        relacion_licencia.cantidad_usuarios 'cantidad_users',
        erp_grupo_empresarial.descripcion as 'Grupo empresarial',
        empresa.razon_social as empresa,
        CONCAT(empresa.id, ' - ', empresa.razon_social) AS empresa_id,
        relacion_licencia.modulo_id 'idModulo'
        FROM erp_licenciamientos licencia 
        LEFT JOIN erp_grupo_empresarial 
        ON licencia.cliente_id =erp_grupo_empresarial.id
        LEFT JOIN erp_relacion_licencias relacion_licencia
        ON relacion_licencia.licencia_id = licencia.id
        LEFT JOIN contabilidad_empresas empresa
        ON empresa.id = relacion_licencia.empresa_id
        ORDER BY erp_grupo_empresarial.descripcion, empresa.razon_social
        ";
    }
}