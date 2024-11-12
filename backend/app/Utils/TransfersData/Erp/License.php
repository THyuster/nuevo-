<?php

namespace App\Utils\TransfersData\Erp;

use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\Erp\SqlClient;
use App\Utils\Constantes\Erp\SqlLicense;
use App\Utils\MyFunctions;
use Exception;

class License
{


    private $sqlClient,  $repositoryDynamicsCrud;
    private $sqlCompanies, $sqlLicense, $date, $nameRelation, $nameDataBase, $myFunctions;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->date = date("Y-m-d H:i:s");
        $this->sqlCompanies = new SqlCompanies;
        $this->sqlClient = new SqlClient;
        $this->sqlLicense = new SqlLicense;
        $this->nameDataBase = "erp_licenciamientos";
        $this->nameRelation = "erp_relacion_licencias";
        $this->myFunctions = new MyFunctions;
    }

    public function getLicense($licenses)
    {
        $licenseArray = [];
        foreach ($licenses as $license) {
            $id = $license->id;
            $encontrado = false;

            foreach ($licenseArray as $obj) {
                if ($obj->id == $id) {
                    $encontrado = true;
                    $obj->moduloRelacion[] = $license->idModulo;
                    break;
                }
            }

            if (!$encontrado) {
                $license->moduloRelacion = array($license->idModulo);
                $licenseArray[] = $license;
            }
        }

        return $licenseArray;
    }

    public function create($newLicense)
    {
        try {

            $newLicense['empresa_id'] = $this->myFunctions->extraerNumero($newLicense['empresa_id']);

            $this->validateLicenseData($newLicense);

            $modules = $newLicense['modulo_id'];
            $companieId = $newLicense['empresa_id'];
            $cantUsers = $newLicense['cantidad_users'];
            unset(
                $newLicense['modulo_id'],
                $newLicense['empresa_id'],
                $newLicense['cantidad_users'],
            );

            $newLicense['estado'] = 1;
            $newLicense['created_at'] = $this->date;

            $idLicense = $this->repositoryDynamicsCrud->getRecordId($this->nameDataBase, $newLicense);

            $modulesData = $this->prepareModulesData($modules, $companieId, $idLicense, $cantUsers);

            return $this->repositoryDynamicsCrud->createInfo($this->nameRelation, $modulesData);
        } catch (\Throwable $error) {
            throw $error;
        }
    }


    public function update($id, $data)
    {
        try {
            $findData = $this->findLicense($id);
            if (isset($findData['error'])) {
                return $findData;
            }

            $data['empresa_id'] = $this->myFunctions->extraerNumero($data['empresa_id']);
            $this->validateLicenseData($data);

            $modules = $data['modulo_id'];
            $companieId = $data['empresa_id'];
            $newUsers = $data['cantidad_users'];
            $data['updated_at'] = $this->date;

            $sql = "SELECT COUNT(*) cantUsers FROM erp_relacion_user_empresas WHERE empresa_id = $companieId AND estado = 1";
            $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $cantUsers = $response[0]->cantUsers;
            if ($cantUsers > $data['cantidad_users']) {
                throw new Exception("La cantidad de usuarios es mayor a la que va a actualizar por favor de inhabilitar usuarios");
            }

            unset($data['modulo_id'], $data['empresa_id'], $data['cantidad_users']);
            $modulesAdd =  $this->addOrDeleteModules($id, $modules,  $companieId);

            $modulesData = $this->prepareModulesData($modulesAdd, $companieId, $id, $newUsers);
            $this->repositoryDynamicsCrud->createInfo($this->nameRelation, $modulesData);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    private function addOrDeleteModules(int $idLicence, array $idModules, $companyId)
    {
        $sql = "SELECT modulo_id as id FROM  erp_relacion_licencias WHERE
        
         licencia_id = $idLicence AND
         empresa_id = $companyId
         
         ";
        $responseModulos = $this->repositoryDynamicsCrud->sqlFunction($sql);

        // $modulesAdd = array_diff($idModules, array_column($responseModulos, 'id'));
        // return [
        //     'idModules' => $idModules,
        //     'modulesAdd' => $modulesAdd,
        //     'responseModulos' => $responseModulos,
        // ];
        // $delete = array_diff(array_column($responseModulos, 'id'), $idModules);
        $deleteIds = implode(",", array_column($responseModulos, 'id'));


        if ($deleteIds) {
            $sqlDelete = "DELETE FROM erp_relacion_licencias WHERE 
              empresa_id = $companyId
            AND
            modulo_id IN ($deleteIds) ";
            $this->repositoryDynamicsCrud->sqlFunction($sqlDelete);
        }
        return $idModules;
    }

    public function validateLicenseData($newLicense)
    {

        $this->findClient($newLicense['cliente_id']);
        $this->findCompanie($newLicense['empresa_id']);
        $this->validateDate($newLicense['fecha_inicial'], $newLicense['fecha_final']);
        $this->validateRelations($newLicense['empresa_id'], $newLicense['cliente_id']);
    }

    public function prepareModulesData($modules, $companieId, $idLicense, $cantUsers)
    {
        // return array_map(function($module ) use ($companieId, $idLicense, $cantUsers) {
        //     return [ 
        //         "empresa_id" => $companieId,
        //         "licencia_id" => $idLicense,
        //         "modulo_id" => $module,
        //         "cantidad_usuarios" => $cantUsers
        //      ];
        // },$modules);


        $inserModules = [];
        foreach ($modules as $module) {
            array_push($inserModules, array(
                "empresa_id" => $companieId,
                "licencia_id" => $idLicense,
                "modulo_id" => $module,
                "cantidad_usuarios" => $cantUsers,
            ));
        }
        return $inserModules;
    }

    public function delete($id)
    {
        $license = $this->findLicense($id);
        if (isset($license['error'])) {
            return $license;
        }
        $this->deleteRelations($id);
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    public function statusUpdate($id)
    {
        try {
            $license = $this->findLicense($id);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, array('estado' => !($license[0]->estado)), $id);
        } catch (\Throwable $error) {
            return $this->returnError($error);
        }
    }

    private function validateDate($initialDate, $finalDate)
    {
        if ($initialDate > $finalDate) {
            throw new \Exception('La fecha final no puede ser antes que la fecha de  inicio', 400);
        }
    }

    private function deleteRelations($id)
    {
        return $this->repositoryDynamicsCrud->sqlFunction($this->sqlLicense->getSqlDeleteAllById($id));
    }

    private function findClient($id)
    {
        $sql = $this->sqlClient->getClient($id);
        return $this->findRecord($sql, "No se encontro al cliente", 404);
    }

    private function findCompanie($id)
    {
        $sql = $this->sqlCompanies->getCompanie($id);
        return $this->findRecord($sql, "No se encontro la empresa", 404);
    }


    private function findLicense($id)
    {
        $sql = $this->sqlLicense->getLicense($id);
        return $this->findRecord($sql, "Licencia no encontrada", 404);
    }
    private function validateRelations($idCompanie, $idClient)
    {
        $sql = $this->sqlLicense->getSqlCheckRelation($idCompanie, $idClient);
        return $this->findRecord($sql, "La empresa no pertenece al grupo empresarial", 400);
    }

    private function findRecord($sql, $messageError, $status)
    {
        $record = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (!$record) {
            throw new \Exception($messageError, $status);
        }
        return $record;
    }
    private function returnError($error)
    {
        return [
            'error' => $error->getMessage(),
            'status' => $error->getCode()
        ];
    }
}
