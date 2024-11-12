<?php
namespace App\Utils\TransfersData\moduloContabilidad;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlMunicipality;


class MunicipalityData{

    protected $repositoryDynamicsCrud;
    protected $nameDataBase;
    protected $date;
    protected $sqlMunicipality;
    
    public function __construct() {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->date =date("Y-m-d H:i:s");
        $this->nameDataBase= "contabilidad_municipios";
        $this->sqlMunicipality= new SqlMunicipality;
    }
    public function create($data){
        $findMunicipality=$this->findMunicipalityByDescripcion($data['descripcion']);
        $findMunicipalityCode=$this->findMunicipalityByDescripcionByCode($data['codigo']);
        
        if($findMunicipality){
            throw new \Exception('Municipio ya existente', 404);
        }
        if($findMunicipalityCode){
            throw new \Exception('Codigo de municipio ya existente', 404);
        }
        
        $data['created_at'] = $this->date; 
        return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $data);
    }

    public function update ($id, $data){
        $findDepartament= $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->nameDataBase WHERE id= $id");
        if(!$findDepartament){
            throw new \Exception('Departamento no existente', 404);
        }
        $data['updated_at'] = $this->date; 
        return $findDepartament= $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
    }

    public function delete($id){
        $findMunicipality= $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->nameDataBase WHERE id= $id");
        if(!$findMunicipality){
            throw new \Exception('Municipio no existente', 404);
        }
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    private function findMunicipalityByDescripcion($description){
        $sql =$this->sqlMunicipality->getSqlFindMunicipality($description);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    private function findMunicipalityByDescripcionByCode($description){
        $sql =$this->sqlMunicipality->getSqlFindMunicipalityByCode($description);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }


    

}