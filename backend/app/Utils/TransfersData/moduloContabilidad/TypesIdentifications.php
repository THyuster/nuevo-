<?php
namespace App\Utils\TransfersData\moduloContabilidad;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlTypesIdentifications;




class TypesIdentifications {

    protected $repositoryDynamicsCrud;

    protected $sqlTypesIdentifications;
    protected $nameDataBase;
    protected $date;

    public function __construct() {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->sqlTypesIdentifications = new SqlTypesIdentifications;
        $this->nameDataBase = "contabilidad_tipos_identificaciones";
        $this->date = date("Y-m-d H:i:s");
    }

    public function create($data) {
        try {
            $findDescripcion = $this->checkDescriptionExist($data['descripcion']);
            if($findDescripcion) {
                throw new \Exception('Tipo de identificacion existente', 400);
            }
            $findCode = $this->checkCodeExist($data['codigo']);
            if($findCode) {
                throw new \Exception('Codigo de tipo de identificacion existente', 400);
            }
            $data['created_at'] = $this->date;
            return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $data);
        } catch (\Throwable $error) {
            throw $error;
        }
    }


    public function update($id, $data) {

        $findData = $this->checkDescriptionAndDirentsId($id, $data['descripcion']);
        if($findData) {
            throw new \Exception('Tipo de identificacion existente', 400);
        }
        $findCode = $this->checkCodeAndDirentsId($id, $data['codigo']);
        if($findCode) {
            throw new \Exception('Codigo de tipo de identificacion existente', 400);
        }

        $data['updated_at'] = $this->date;
        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
    }


    public function delete($id) {

        $findTypeIdentification = $this->repositoryDynamicsCrud->getInfoAllOrById($this->nameDataBase, [], $id);
        if(!$findTypeIdentification) {
            throw new \Exception('Tipo de identificacion   no existente', 404);
        }
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }



    private function findData($id) {

        $findThirdParty = $this->repositoryDynamicsCrud->getInfoAllOrById($this->nameDataBase, [], $id);
        if(!$findThirdParty) {
            throw new \Exception('Tipo de tercero ya existente', 404);
        }
        return $findThirdParty;
    }

    private function checkDescriptionAndDirentsId($id, $descripcion) {
        $sql = $this->sqlTypesIdentifications->sqlGetTypesIdentificationByDescripcionAndDiferentsId($id, $descripcion);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    private function checkCodeAndDirentsId($id, $code) {
        $sql = $this->sqlTypesIdentifications->queryIdentificationsByCodeAndId($id, $code);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    private function checkCodeExist($code) {
        $sql = $this->sqlTypesIdentifications->sqlGetTypesIdentificationByCode($code);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    private function checkDescriptionExist($descripcion) {
        $sql = $this->sqlTypesIdentifications->sqlGetTypesIdentificationByDescripcion($descripcion);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }




}