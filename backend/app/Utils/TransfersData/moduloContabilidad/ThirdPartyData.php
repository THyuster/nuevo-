<?php
namespace App\Utils\TransfersData\moduloContabilidad;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlThirdParty;
use GuzzleHttp\Promise\Promise;


class ThirdPartyData{

    protected $repositoryDynamicsCrud;
    
    protected $sqlThirdParty;
    protected $nameDataBase;
    protected $date;
    
    public function __construct() {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->sqlThirdParty= new SqlThirdParty;
        $this->nameDataBase= "contabilidad_tipos_terceros";
        $this->date =date("Y-m-d H:i:s");
    }

    public function create($data){
        $this->checkDataExist($data['descripcion']);  
        $this->checkCodeExist($data['codigo']);
        $data['created_at'] = $this->date; 
        return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $data);
    }


    public function update ($id, $data){
      try {
        $this->findData($id);
        $this->checkDataExist($data['descripcion']);  
        $data['updated_at'] = $this->date; 
        // return $data;
        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
      } catch (\Throwable $th) {
        throw $th;
      }
    }
    

    public function delete($id){
        
    
        $findThirdParty= $this->repositoryDynamicsCrud->getInfoAllOrById($this->nameDataBase, [], $id);
         if(!$findThirdParty){
            throw new \Exception('Tipo de tercero no existente', 404);
        }
        
        $findRelations =$this->getRelationTypesThird($id);
        if($findRelations){
            throw new \Exception('No se puede eliminar el registro porque se esta utilizando en terceros', 400);
        }


        return  $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    private function findThirdPartyByDescripcion($description){
        $sql =$this->sqlThirdParty->getSqlFindThirdParty($description);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

       private function  findData($id){
        
        $findThirdParty= $this->repositoryDynamicsCrud->getInfoAllOrById($this->nameDataBase, [], $id);
        if(!$findThirdParty){
            throw new \Exception('Tipo de tercero ya existente', 404);
        }
        return $findThirdParty;
    }

    private function checkDataExist($data){
         $findThirdPartyExist=$this->findThirdPartyByDescripcion($data);
        if($findThirdPartyExist){
            throw new \Exception('Tipo de tercero ya existente', 404);
        }
        return $findThirdPartyExist;
    }
    private function checkCodeExist($code){
        
         $sql=$this->sqlThirdParty->getSqlFindThirdPartyByCode($code);
         $findCode=$this->repositoryDynamicsCrud->sqlFunction($sql);

        if($findCode){
            throw new \Exception('Codigo ya existente', 404);
        }
        return $findCode;
    }
    private function getRelationTypesThird($id){
        $sql =$this->sqlThirdParty->getSqlDataRelationsTypesThirds($id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }


    

}