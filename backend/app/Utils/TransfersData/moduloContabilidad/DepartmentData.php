<?php
namespace App\Utils\TransfersData\moduloContabilidad;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlDepartament;


class DepartmentData{

    protected $repositoryDynamicsCrud;
    protected $sqlDepartament;
    protected $date;
    
    public function __construct() {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->sqlDepartament = new SqlDepartament;
        $this->date =date("Y-m-d H:i:s");
    }
    public function create($data){
        $departmentDescripcion=$this->findDepartamentByDescripcion($data['descripcion']);
        if($departmentDescripcion){
            throw new \Exception('Departamento existente', 400);
        }
        
        $departmentCode=$this->findDepartamentByCode($data['codigo']);
        if($departmentCode){
            throw new \Exception('codigo de departamento existente', 400);
        }
        
        $data['created_at'] = $this->date; 
        return $this->repositoryDynamicsCrud->createInfo('contabilidad_departamentos', $data);
    }

    public function update ($id, $data){
        $findDepartament= $this->repositoryDynamicsCrud->getInfoAllOrById('contabilidad_departamentos', [], $id);
        if(!$findDepartament){
            throw new \Exception('Departamento no existente', 404);
        }
      
        $data['updated_at'] = $this->date; 
        return $findDepartament= $this->repositoryDynamicsCrud->updateInfo('contabilidad_departamentos', $data, $id);
    }

    public function delete($id){
        $findDepartament= $this->repositoryDynamicsCrud->getInfoAllOrById('contabilidad_departamentos', [], $id);
        if(!$findDepartament){
            throw new \Exception('Departamento no existente', 404);
        }
        return $findDepartament= $this->repositoryDynamicsCrud->deleteInfoAllOrById('contabilidad_departamentos', $id);
    }

    private function findDepartamentByDescripcion($description){
        $sql =$this->sqlDepartament->getSqlFindDepartament($description);
        return  $this->repositoryDynamicsCrud->sqlFunction($sql);
         
    }
    private function findDepartamentByCode($code){
        $sql =$this->sqlDepartament->getSqlFindDepartamentByCode($code);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
       
    }


    

}