<?php
namespace App\Utils\Constantes\ModuloContabilidad;

class SqlMunicipality{
    

    public function getSqlFindMunicipality($description){
        return "SELECT * FROM contabilidad_municipios WHERE descripcion = '$description' ";
    }
    public function getSqlFindMunicipalityBy($id){
        return "SELECT * FROM contabilidad_municipios WHERE `id` = '$id' ";
    }
    public function getSqlFindMunicipalityByCode($code){
        return "SELECT * FROM contabilidad_municipios WHERE codigo = '$code' ";
    }
    public function getSqlMunicipalityByDepartment(){
        return "SELECT contabilidad_municipios.id , contabilidad_municipios.codigo, contabilidad_municipios.descripcion, contabilidad_municipios.departamento_id, contabilidad_departamentos.descripcion as departamento FROM contabilidad_municipios INNER JOIN contabilidad_departamentos WHERE contabilidad_municipios.departamento_id = contabilidad_departamentos.id";
    }
}