<?php

namespace App\Utils\TransfersData\Erp;


use App\Utils\Repository\RepositoryDynamicsCrud;

class TypeCharge
{
    protected $repositoryDynamicsCrud;
    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    }
    public function findTypeCharge($id)
    {
        $sql = "SELECT * FROM tipo_cargo WHERE id = " . $id;
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new \Exception('Tipo no encontrado');
        }
        return $response;
    }


}
