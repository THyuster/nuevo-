<?php

namespace App\Utils\Constantes\ModuloConfiguracion;

class DisenoMenus
{
    protected $sqlGetMenusByModules = "SELECT DISTINCT erp_menuses.id, erp_menuses.descripcion, erp_menuses.estado, erp_menuses.modulo_id, erp_menuses.orden FROM erp_menuses INNER JOIN erp_modulos ON erp_menuses.modulo_id = erp_modulos.id WHERE erp_menuses.modulo_id = ";
    protected $sqlGetMenuByName = "SELECT * FROM `erp_menuses` WHERE descripcion = ";

    protected $sqlGetModuleById = "SELECT * FROM `erp_modulos` WHERE id = ";
   
    public function sqlGetMenusByModuleId($moduleid)
    {
        return $this->sqlGetMenusByModules . "'$moduleid'". "ORDER BY erp_menuses.orden, erp_menuses.descripcion";
    }

    public function sqlGetModule($id){
        return $this->sqlGetModuleById ."'$id'";
    }

    public function sqlGetMenuByName($name,$id)
    {
        return "SELECT * FROM `erp_menuses` WHERE descripcion = '$name' AND erp_menuses.modulo_id= '$id'";
        return $this->sqlGetMenuByName . "'$name'";
    }
}