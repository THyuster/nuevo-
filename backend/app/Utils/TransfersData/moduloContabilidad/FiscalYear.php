<?php
namespace App\Utils\TransfersData\moduloContabilidad;

use App\Utils\CatchToken;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\Constantes\ModuloContabilidad\SqlFiscalYear;
use App\Utils\Constantes\ModuloContabilidad\SqlPeriod;
use App\Utils\MyFunctions;

class FiscalYear
{

    protected $repositoryDynamicsCrud;
    protected $nameDataBase;
    protected $date, $sqlCompanie, $sqlPeriod, $sqlFiscalYear, $myFunctions, $catchToken;

    public function __construct()
    {

        $this->date = date("Y-m-d H:i:s");
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_afiscals";
        $this->sqlCompanie = new SqlCompanies;
        $this->sqlFiscalYear = new SqlFiscalYear;
        $this->sqlPeriod = new SqlPeriod;
        $this->myFunctions = new MyFunctions;
        $this->catchToken = new CatchToken;
    }

    public function create($createData)
    {
        $companieId = $this->catchToken->Claims();
        $this->findCompanie($companieId);
        $createData['empresa_id'] = $companieId;

        $createData['created_at'] = $this->date;
        $createData['estado'] = 1;
        return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $createData);

    }

    public function update($id, $data)
    {

        $this->findFiscalYear($id);
        $companieId = $this->catchToken->Claims();
        $this->findCompanie($companieId);
        $data['empresa_id'] = $companieId;

        $data['updated_at'] = $this->date;
        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);

    }

    public function delete($id)
    {
        $this->findFiscalYear($id);
        $sql = $this->sqlFiscalYear->findFiscalYearRelationsPeriod($id);
        $getPeriod = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!empty($getPeriod)) {
            throw new \Exception('El año fiscal tiene un periodo en uso, por favor eliminar el periodo', 400);
        }
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    public function updateStatus($id)
    {
        try {
            $findFiscal = $this->findFiscalYear($id);
            $newStatus = array('estado' => !$findFiscal[0]->estado);

            if ($newStatus['estado'] == 0) {
                $this->disableStatus($id);
            }
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newStatus, $id);
        } catch (\Throwable $error) {
            return $error;
        }
    }




    private function disableStatus($id)
    {

        $sql = $this->sqlFiscalYear->disableStatusPeriodById($id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);

    }


    private function findFiscalYear($id)
    {
        $sql = $this->sqlFiscalYear->findFiscalYear($id);
        $getFiscalYear = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$getFiscalYear) {
            throw new \Exception('Año fiscal  no existente', 404);
        }
        return $getFiscalYear;
    }

    private function findCompanie($id)
    {
        $sql = $this->sqlCompanie->getCompanie($id);
        $getCompanie = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$getCompanie) {
            throw new \Exception('Empresa no existente', 404);
        }
        return $getCompanie;
    }
}