<?php
namespace App\Utils\Constantes\ModuloContabilidad;

class SqlBranch {


    public function getSqlFindBranch($description) {
        return "SELECT * FROM contabilidad_sucursales WHERE descripcion = '$description' ";
    }
    public function getSqlFindBranchByCode($code) {
        return "SELECT * FROM contabilidad_sucursales WHERE codigo = '$code' ";
    }

    public function getSqlBranchByMunicipalityByDepartment() {
        return "
        SELECT 
        contabilidad_sucursales.id,
        contabilidad_sucursales.codigo,
        contabilidad_sucursales.descripcion,
        contabilidad_sucursales.estado,
        contabilidad_sucursales.municipio_id,
        contabilidad_municipios.descripcion as municipio,
        contabilidad_departamentos.descripcion as departamento,
        contabilidad_empresas.id as 'empresa_id',
        contabilidad_empresas.razon_social as 'Empresa'
        FROM contabilidad_sucursales
        INNER JOIN contabilidad_municipios 
        ON contabilidad_sucursales.municipio_id = contabilidad_municipios.id
        INNER JOIN  contabilidad_departamentos
        ON contabilidad_municipios.departamento_id=contabilidad_departamentos.id
        INNER JOIN contabilidad_empresas 
        ON contabilidad_sucursales.empresa_id = contabilidad_empresas.id;
        ";
    }

    public function getSqlBranchByDescripcionAndCode($id, $descripcion) {
        return "SELECT * FROM contabilidad_sucursales WHERE contabilidad_sucursales.descripcion = '$descripcion' AND contabilidad_sucursales.id != '$id'";
    }

    public function getSqlFindCompanieByCode($id) {
        return "SELECT * FROM contabilidad_empresas WHERE contabilidad_empresas.id = '$id' ";
    }
}