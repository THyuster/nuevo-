<?php

namespace App\Utils\TransfersData\moduloContabilidad;

use App\Utils\Constantes\ModuloContabilidad\SqlReceipt;

use App\Utils\Repository\RepositoryDynamicsCrud;

class Receipt
{

    protected $repositoryDynamicsCrud;
    protected $nameDataBase;
    protected $sqlReceipt;
    protected $date;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_tipos_comprobantes";
        $this->sqlReceipt = new SqlReceipt;
        $this->date = date("Y-m-d H:i:s");
    }

    public function create($data)
    {

        $findReceipt  = $this->findReceiptByCode($data['codigo']);

        if ($findReceipt) {
            throw new \Exception("Codigo existente", 400);
        }
        $data['estado'] = 1;
        $data['created_at'] = $this->date;

        return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $data);
    }

    public function update($id, $data)
    {
        $this->findReceiptById($id);

        $findCode = $this->getPrexisByDiferentCode($id, $data['codigo']);
        if ($findCode) {
            throw new \Exception("Codigo existente", 400);
        }

        $data['updated_at'] = $this->date;
        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
    }

    public function updateStatus($id)
    {
        try {
            $findReceipt = $this->findReceiptById($id);

            $newStatus = array('estado' => !$findReceipt[0]->estado);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newStatus, $id); //code...
        } catch (\Throwable $e) {
            return $e;
        }
    }
    public function updateSign($id)
    {
        try {
            $findReceipt = $this->findReceiptById($id);
            $newSign = array('signo' => ($findReceipt[0]->signo == 1) ? -1 : 1);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newSign, $id);
        } catch (\Throwable $e) {
            return $e;
        }
    }
    private function findReceiptById($id)
    {
        $sql = $this->sqlReceipt->getReceipt($id);
        $findPrefixed = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$findPrefixed) {
            throw new \Exception('Comprobante no existente', 404);
        }
        return $findPrefixed;
    }

    private function findReceiptByCode($id)
    {
        $sql = $this->sqlReceipt->getReceiptByCode($id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function getPrexisByDiferentCode($id, $code)
    {
        $sql = $this->sqlReceipt->getReceiptByCodeDiferent($id, $code);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
}
