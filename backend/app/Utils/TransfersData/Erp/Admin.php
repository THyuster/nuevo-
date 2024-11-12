<?php

namespace App\Utils\TransfersData\Erp;


use App\Utils\Constantes\Erp\SqlAdmin;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\AdminGeneral\AdminServices;
use App\Utils\TypesAdministrators;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class Admin
{


    protected $adminServices, $repositoryDynamicsCrud, $sqlAdmin;

    public function __construct()
    {
        $this->adminServices = new AdminServices;
        $this->sqlAdmin = new SqlAdmin;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    }
    public function transferData($data)
    {
        $newData = [];
        foreach ($data as $datosEmpresa) {
            $id = $datosEmpresa->id;
            $encontrado = false;

            foreach ($newData as $obj) {
                if ($obj->id == $id) {
                    $encontrado = true;
                    $obj->empresas[] = array(
                        "id" => $datosEmpresa->empresaId,
                        "empresa" => $datosEmpresa->empresa,
                        "imagen" => $datosEmpresa->imgEmpresa,
                    );
                    break;
                }
            }

            if (!$encontrado) {
                $datosEmpresa->empresas[] = array(
                    "id" => $datosEmpresa->empresaId,
                    "empresa" => $datosEmpresa->empresa,
                    "imagen" => $datosEmpresa->imgEmpresa,
                );
                $newData[] = $datosEmpresa;
            }
            unset($datosEmpresa->empresaId);
            unset($datosEmpresa->empresa);
            unset($datosEmpresa->imgEmpresa);
        }
        return $newData;
    }




    public function create($newUser)
    {
        try {
            $sql = $this->sqlAdmin->findRecordByClient($newUser['cliente_id']);
            $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
            if ($response) {
                throw new Exception(__("messages.duplicateAdminErrorMessage"), Response::HTTP_CONFLICT);
            }
            $newUser['tipo_administrador'] = TypesAdministrators::ADMINISTRATOR_BUSINESS_GROUP;
            return $this->adminServices->createUser($newUser);
        } catch (\Throwable $error) {
            throw $error;
        }
    }




    public function update($idAdmin, $updatedUser)
    {
        try {
            return $this->adminServices->updateUser($idAdmin, $updatedUser);
        } catch (\Throwable $error) {
            throw $error;
        }
    }



    public function delete($id)
    {

        try {
            $this->findAdmin($id);
            $sql = $this->sqlAdmin->findClientsByUser($id);
            $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

            if ($response[0]->count > 1) {
                throw new Exception(__("messages.associatedInAdminUsersErrorMessage"), Response::HTTP_CONFLICT);
            }
            return $this->adminServices->deleteUser($id);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function statusUpdate($id)
    {
        try {
            return $this->adminServices->statusUpdateUser($id);
        } catch (\Throwable $error) {
            return $this->returnError($error);
        }
    }

    public function findAdmin($id)
    {
        $sql = $this->sqlAdmin->getAdmin($id);
        return $this->findRecord($sql, __("messages.notFoundRequestMessage"), Response::HTTP_NOT_FOUND);
    }
    private function findRecord($sql, $messageError, $status)
    {

        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new \Exception($messageError, $status);
        }
        return $response;
    }


    private function returnError($error)
    {
        return [
            'error' => $error->getMessage(),
            'status' => $error->getCode()
        ];
    }
}
