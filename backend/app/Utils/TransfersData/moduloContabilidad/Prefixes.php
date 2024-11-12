<?php

namespace App\Utils\TransfersData\moduloContabilidad;
use App\Utils\Constantes\ModuloContabilidad\SqlPrefixes;

use App\Utils\Repository\RepositoryDynamicsCrud;

class Prefixes {

    protected $repositoryDynamicsCrud;
    protected $nameDataBase;
    protected $sqlPrefixes;

    public function __construct() {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_prefijos";
        $this->sqlPrefixes =new SqlPrefixes;
        
    }

    public function create ($data){
        $findCode  = $this->findPrexeByCode($data['codigo']);
        
        if($findCode){
            throw new \Exception("Codigo existente", 400);
        }
        $data['estado']= 1;
        return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $data);
    }

    public function update ($id, $data){
        $this->findPrexeById($id);      
        
        $findCode=$this->getPrexisByDiferentCode($id, $data['codigo']);
        if($findCode){
            throw new \Exception("Codigo existente", 400);
        }
        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
    }

    public function updateStatus($id){
        $findPrefixesd = $this->findPrexeById($id);
        
        $newStatus = array('estado'=>!$findPrefixesd[0]->estado);
        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newStatus, $id);
    }
    private function findPrexeById($id){
        $sql = $this->sqlPrefixes->getPrefixed($id);
        $findPrefixed= $this->repositoryDynamicsCrud->sqlFunction($sql);
        if(!$findPrefixed){
            throw new \Exception('Prefijo no existente', 404);
        }
        return $findPrefixed;
    }

    private function findPrexeByCode($id){
        $sql = $this->sqlPrefixes->getPrexisByCode($id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function getPrexisByDiferentCode($id, $code){
        $sql = $this->sqlPrefixes->getPrexisByCodeDiferent($id, $code);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
   

}
