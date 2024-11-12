<?php
namespace App\Utils\Constantes\ModuloContabilidad;

class SqlFiscalYear
{


    public function findFiscalYearRelationsPeriod($id)
    {
        return "
        SELECT * FROM 
        contabilidad_periodos WHERE contabilidad_periodos.afiscal_id = $id";
    }
    public function findFiscalYearRelationsCompanie()
    {
        return "
        SELECT  
        contabilidad_afiscals.id, 
        contabilidad_afiscals.estado, 
        contabilidad_afiscals.descripcion, 
        contabilidad_empresas.razon_social as 'Empresa',
        contabilidad_afiscals.afiscal as 'año fiscal',
        contabilidad_afiscals.afiscal,
        CONCAT(contabilidad_afiscals.empresa_id, ' - ', contabilidad_empresas.razon_social) AS 'empresa_id' 
        FROM contabilidad_afiscals LEFT JOIN contabilidad_empresas 
        ON contabilidad_empresas.id= contabilidad_afiscals.empresa_id;
        ";
    }

    public function findFiscalYear($id)
    {
        return "SELECT * FROM contabilidad_afiscals WHERE contabilidad_afiscals.id = '$id'";
    }

    public function getSqlFiscalYearById($id)
    {
        return "SELECT contabilidad_afiscals.id FROM contabilidad_afiscals 
                WHERE contabilidad_afiscals.empresa_id = '$id'";
    }
    public function getSqlFiscalYear()
    {
        return "SELECT contabilidad_afiscals.*,
        contabilidad_empresas.razon_social 'Empresa'
        FROM contabilidad_afiscals
        INNER JOIN contabilidad_empresas
        ON contabilidad_empresas.id = contabilidad_afiscals.empresa_id";
    }

    public function disableStatusPeriodById($id)
    {
        return
            "UPDATE contabilidad_periodos INNER JOIN contabilidad_afiscals 
            ON contabilidad_periodos.afiscal_id = contabilidad_afiscals.id SET contabilidad_periodos.estado = 0 
            WHERE contabilidad_afiscals.id = '$id';
        ";
    }
    public function getIdAndYear($id)
    {
        return
            "SELECT contabilidad_afiscals.id, contabilidad_afiscals.afiscal
             FROM  contabilidad_afiscals
             WHERE contabilidad_afiscals.id = " . $id;
    }
}