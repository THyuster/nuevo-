<?php

namespace App\Utils\TransfersData\moduloContabilidad;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlFiscalYear;
use App\Utils\Constantes\ModuloContabilidad\SqlPeriod;
use App\Utils\MyFunctions;


class Period {

    protected $repositoryDynamicsCrud;
    protected $nameDataBase;
    protected $date;

    protected $sqlPeriod;
    protected $sqlFiscalYear;
    protected $myFunctions;

    public function __construct() {

        $this->date = date("Y-m-d H:i:s");
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_periodos";

        $this->sqlPeriod = new SqlPeriod;
        $this->sqlFiscalYear = new SqlFiscalYear;
        $this->myFunctions = new MyFunctions;
    }

    public function create($createData) {
        $this->validatePeriodData($createData);
        $createData['created_at'] = $this->date;
        $createData['estado'] = 1;
        return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $createData);
    }

    public function update($id, $data) {
        try {
            $this->findPeriod($id);
            $this->validatePeriodData($data, $id);
            $data['updated_at'] = $this->date;
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function delete($id) {

        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    public function updateStatus($id) {
        try {
            $findPeriod = $this->findPeriod($id);
            $newStatus = array('estado' => !$findPeriod[0]->estado);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newStatus, $id);
        } catch (\Throwable $error) {
            return $error;
        }
    }

    public function replicateYearByYear($request) {
        $data = $request->all();
        $sql = $this->sqlPeriod->checkId($data['lastYear'], $data['yearNew']);
        $checkedId = ($this->repositoryDynamicsCrud->sqlFunction($sql));

        if($checkedId[0]->num_rows != 2) {
            throw new \Exception('Años no existentes', 400);
        }

        $sqlGetIdAndYear = $this->sqlFiscalYear->getIdAndYear($data['yearNew']);
        $getAfiscal = $this->repositoryDynamicsCrud->sqlFunction($sqlGetIdAndYear);
        $newYear = $getAfiscal[0]->afiscal;


        $getSql = $this->sqlPeriod->getplicateYear($data['yearNew'], $data['lastYear'], $newYear);

        return $this->repositoryDynamicsCrud->sqlFunction($getSql);

    }

    public function getPeriodsByYear($id) {
        $sql = $this->sqlPeriod->filterPeriodsByYear($id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function findFiscalYear($id) {
        $sql = $this->sqlFiscalYear->findFiscalYear($id);
        $getFiscalYear = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if(!$getFiscalYear) {
            throw new \Exception('Año fiscal  no existente', 404);
        }
        return $getFiscalYear;
    }

    private function findPeriod($id) {
        $sql = $this->sqlPeriod->findPeriod($id);
        $getPeriod = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if(!$getPeriod) {
            throw new \Exception('Periodo no existente', 404);
        }
        return $getPeriod;
    }
    public function validatePeriodData($data, $id = null) {
        $getYear = $this->findFiscalYear($data['afiscal_id']);
        $this->validateYearDate($data['fecha_inicio'], $getYear[0]->afiscal);
        if($data['fecha_inicio'] > $data['fecha_final']) {
            throw new \Exception('La fecha final no puede ser antes que la fecha de  inicio', 400);
        }
        $checkData = ($id) ? $this->repositoryDynamicsCrud->sqlFunction($this->sqlPeriod->DatecheckWithId($id, $data['fecha_inicio'], $data['fecha_final'])) :
            $checkData = $this->repositoryDynamicsCrud->sqlFunction($this->sqlPeriod->Datecheck($data['fecha_inicio'], $data['fecha_final']));
        if($checkData) {
            throw new \Exception('Las fechas ingresadas ya las tiene un periodo', 400);
        }
    }

    private function validateYearDate($expectedYear, $year) {
        $newYear = date("Y", strtotime($expectedYear));
        if($newYear != $year) {
            throw new \Exception('El año seleccionado no concuerda', 400);
        }
    }
}
