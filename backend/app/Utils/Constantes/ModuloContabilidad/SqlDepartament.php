<?php
namespace App\Utils\Constantes\ModuloContabilidad;

class SqlDepartament{
    

    public function getSqlFindDepartament($description){
        return "SELECT * FROM contabilidad_departamentos WHERE descripcion = '$description' ";
    }
    public function getSqlFindDepartamentByCode($codigo){
        return "SELECT * FROM contabilidad_departamentos WHERE codigo = '$codigo' ";
    }
    
}