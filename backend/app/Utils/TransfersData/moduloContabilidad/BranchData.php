<?php

namespace App\Utils\TransfersData\moduloContabilidad;

use App\Utils\CatchToken;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlBranch;


class BranchData
{

    protected $repositoryDynamicsCrud;
    protected $sqlBranch;
    protected $date;
    protected $nameDataBase, $catchToken;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->sqlBranch = new SqlBranch;
        $this->nameDataBase = "contabilidad_sucursales";
        $this->date = date("Y-m-d H:i:s");
        $this->catchToken = new CatchToken;
    }
    public function create($data)
    {
        $this->findBranchByDescripcion($data['descripcion']);
        $this->findBranchByDescripcionByCode($data['codigo']);
        $empresaId = $this->catchToken->Claims();
        $this->findCompanieById($empresaId);


        $data['empresa_id'] = $empresaId;
        $data['created_at'] = $this->date;
        $data['estado'] = 1;
        return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $data);
    }

    public function update($id, $data)
    {
        $findBranch = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->nameDataBase WHERE id =  $id");
        if (!$findBranch) {
            throw new \Exception('Sucursal no existente', 404);
        }

        $this->findBranchByDescripcionAndCode($id, $data['descripcion']);
        $empresaId = $this->catchToken->Claims();
        $this->findCompanieById($empresaId);
        $data['empresa_id'] = $empresaId;
        $data['updated_at'] = $this->date;
        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
    }

    public function changeStatus($id)
    {

        $findBranch = $this->repositoryDynamicsCrud->getInfoAllOrById($this->nameDataBase, [], $id);
        if (!$findBranch) {
            throw new \Exception('Sucursal no existente', 404);
        }
        $findBranch[0]->estado = !$findBranch[0]->estado;

        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, array('estado' => $findBranch[0]->estado), $id);
    }


    public function delete($id)
    {
        $findBranch = $this->repositoryDynamicsCrud->getInfoAllOrById($this->nameDataBase, [], $id);
        if (!$findBranch) {
            throw new \Exception('Sucursal no existente', 404);
        }
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    private function findCompanieById($id)
    {
        $sql = $this->sqlBranch->getSqlFindCompanieByCode($id);
        $findCompanie = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$findCompanie) {
            throw new \Exception('Empresa no existente', 400);
        }
        return $findCompanie;
    }

    private function findBranchByDescripcion($description)
    {
        $sql = $this->sqlBranch->getSqlFindBranch($description);
        $findDescription = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($findDescription) {
            throw new \Exception('Sucursal ya existente', 400);
        }
        return $findDescription;
    }
    private function findBranchByDescripcionByCode($code)
    {
        $sql = $this->sqlBranch->getSqlFindBranchByCode($code);
        $findCode = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($findCode) {
            throw new \Exception('Codigo de sucursal ya existente', 400);
        }
        return $findCode;
    }

    private function findBranchByDescripcionAndCode($id, $descipcion)
    {
        $sql = $this->sqlBranch->getSqlBranchByDescripcionAndCode($id, $descipcion);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
}
