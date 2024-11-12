<?php

namespace App\Utils\TransfersData\Erp;

use App\Utils\Constantes\Erp\SqlAdminUser;
use App\Utils\Constantes\Erp\SqlClient;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\AdminGeneral\AdminServices;
use App\Utils\TransfersData\moduloContabilidad\Companies;
use App\Utils\TypesAdministrators;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class AdminUser
{


    protected $adminServices, $repositoryDynamicsCrud;
    protected $sqlClient, $sqlAdminUser, $sqlCompanie, $servicesCompanies;
    protected $nameDBRelation = "erp_relacion_user_empresas";

    public function __construct()
    {
        $this->adminServices = new AdminServices;
        $this->sqlClient = new SqlClient;
        $this->sqlAdminUser = new SqlAdminUser;
        $this->sqlCompanie = new SqlCompanies;
        $this->servicesCompanies = new Companies;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    }

    public function dataMapper($dataArray)
    {
        $newData = [];
        foreach ($dataArray as $value) {
            $id = $value->id;
            $flag = false;
            foreach ($newData as $obj) {
                if ($obj->id == $id) {
                    $flag = true;
                    $obj->data[] = array(
                        "idEmpresa" => $value->companieId,
                        "empresa" => $value->razonSocial,
                        "estado" => $value->stateCompanie,
                        "idRelacion" => $value->idRelation,
                    );
                    break;
                }
            }
            if (!$flag) {
                $value->data[] = array(
                    "idEmpresa" => $value->companieId,
                    "empresa" => $value->razonSocial,
                    "estado" => $value->stateCompanie,
                    "idRelacion" => $value->idRelation,
                );
                $newData[] = $value;
            }
            unset($value->companieId, $value->razonSocial, $value->stateCompanie);
        }
        // print_r(json_encode($newData));
        return $newData;
    }

    public function getUser()
    {
        return Auth::check() ? Auth::user() : "No logueado";
    }

    public function validateCompanyAssignment(array $idsCompanies)
    {
        array_map(function ($companieId) {
            $sql = $this->sqlAdminUser->getSqlNumberUsersByCompanie($companieId);

            //trae el cupo de licencias que tiene el grupo empresarial
            $sql2 = $this->sqlAdminUser->getSqlNumberQuotaByCompanie($companieId);

            $responseUsers = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $responseLicenses = $this->repositoryDynamicsCrud->sqlFunction($sql2);

            $companie = $responseUsers[0]->companie;
            $numberUsers = $responseUsers[0]->cantUsers;
            $numberLicenses = $responseLicenses[0]->quotaByCompanie;

            if ($numberUsers >= $numberLicenses) {
                throw new Exception(__('messages.maxUsersLimitMessageInCompany'), HttpFoundationResponse::HTTP_FORBIDDEN);
            }
        }, $idsCompanies);
    }

    public function create($newUser)
    {

        try {
            $user = $this->getUser();

            $slq = $this->sqlClient->getIdClientByUser($user->id);
            $response = $this->repositoryDynamicsCrud->sqlFunction($slq);


            $this->servicesCompanies->checkCompanies($response[0]->id, $newUser['companies_id']);

            $this->validateCompanyAssignment($newUser['companies_id']);
            $admin = array(
                'name' => $newUser['name'],
                'email' => $newUser['email'],
                'tipo_administrador' => TypesAdministrators::COMPANY_ADMINISTRATOR,
                'cliente_id' => $response[0]->id,
                'password' => $newUser['password']
            );

            $userId = $this->adminServices->createUser($admin);
            $arrayCompanieUser = $this->arrayRelation($userId, $newUser['companies_id']);
            return $this->repositoryDynamicsCrud->createInfo($this->nameDBRelation, $arrayCompanieUser);
        } catch (\Throwable $error) {
            throw $error;
        }
    }



    public function update($idAdmin, $updatedUser)
    {
        try {
            $user = $this->getUser();
            $slq = $this->sqlClient->getIdClientByUser($user->id);
            $response = $this->repositoryDynamicsCrud->sqlFunction($slq);

            $updatedUser['cliente_id'] = $response[0]->id;

            if (isset($updatedUser['companies_id'])) {
                $companiesId = $updatedUser['companies_id'];
                unset($updatedUser['companies_id']);
            }

            if (empty($companiesId)) {
                throw new Exception(__("messages.noCompanySelectedMessage"), HttpFoundationResponse::HTTP_BAD_REQUEST);
            }

            $this->adminServices->updateUser($idAdmin, $updatedUser);

            $this->servicesCompanies->checkCompanies($response[0]->id, $companiesId);
            $newCompanies = $this->addOrDeleteCompanies($idAdmin, $companiesId);

            if (!$newCompanies) {
                return __("messages.processFinishedMessage");
            }
            $arrayCompanieUser = $this->arrayRelation($idAdmin, $newCompanies);
            return $this->repositoryDynamicsCrud->createInfo($this->nameDBRelation, $arrayCompanieUser);
        } catch (\Throwable $error) {
            throw $error;
        }
    }




    public function delete($id, $companieId)
    {

        try {

            $sql = $this->sqlAdminUser->getSqlDataUsersT4T3ByCompanie($companieId);
            $reponse = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $users = $reponse[0]->users;
            $admins = $reponse[0]->admins;
            if ($admins == 1 && $users > 0) {
                throw new Exception(__('messages.lastAdminWithUsersMessage'), HttpFoundationResponse::HTTP_FORBIDDEN);
            }
            $sql = $this->sqlCompanie->sqlDeleteRelationUserCompanie($id);
            $this->repositoryDynamicsCrud->sqlFunction($sql);

            $this->adminServices->deleteUser($id);

            $sql = $this->sqlCompanie->sqlDeleteRelationUserClient($id);
            return $this->repositoryDynamicsCrud->sqlFunction($sql);
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
    public function statusUpdateByRelationByUserAdmin(array $arrayRelacion)
    {
        try {
            for ($i = 0; $i < sizeof($arrayRelacion); $i++) {
                # code...
                $id = $arrayRelacion[$i];
                $response = $this->findRelation($id);
                if (!$response[0]->estado) {
                    $this->validateCompanyAssignment(array($response[0]->empresaId));
                }
    
                $status = array('estado' => ($response[0]->estado) ? 0 : 1);
    
                $response = $this->repositoryDynamicsCrud->updateInfo($this->nameDBRelation, $status, $id);
            }
            return true;
        } catch (\Throwable $error) {
            throw $error;
        }
    }
    public function statusUpdateByCompanie($id)
    {
        try {
            // for ($i = 0; $i < sizeof($arrayRelacion); $i++) {
                # code...
                // $id = $arrayRelacion[$i];
                $response = $this->findRelation($id);
                if (!$response[0]->estado) {
                    $this->validateCompanyAssignment(array($response[0]->empresaId));
                }
    
                $status = array('estado' => ($response[0]->estado) ? 0 : 1);
    
                return $response = $this->repositoryDynamicsCrud->updateInfo($this->nameDBRelation, $status, $id);
            // }
            // return true;
        } catch (\Throwable $error) {
            throw $error;
        }
    }


    private function addOrDeleteCompanies(int $idAdmin, array $idCompanies)
    {
        $sql = $this->sqlAdminUser->sqlGetCompaniesId($idAdmin);
        $responseCompanies = $this->repositoryDynamicsCrud->sqlFunction($sql);


        $companiesAdd = array_diff($idCompanies, array_column($responseCompanies, 'id'));
        $delete = array_diff(array_column($responseCompanies, 'id'), $idCompanies);
        $deleteIds = implode(",", $delete);

        $this->validateCompanyAssignment($companiesAdd);
        if ($deleteIds) {
            $sqlDelete = $this->sqlAdminUser->sqlDeleteCompaniesId($idAdmin, $deleteIds);
            $this->repositoryDynamicsCrud->sqlFunction($sqlDelete);
        }
        return $companiesAdd;
    }

    public function deleteRelations($idAdmin)
    {
        $sql = $this->sqlAdminUser->getSqlDeleteRelation($idAdmin);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function findRelation($id)
    {

        $sql = $this->sqlAdminUser->getSqlRelation($id);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new Exception(__("messages.relationNotFoundMessage"), HttpFoundationResponse::HTTP_NOT_FOUND);
        }
        return $response;
    }
    private function arrayRelation($idAdmin, $companiesId)
    {

        return array_map(function ($companyId) use ($idAdmin) {

            return [
                'empresa_id' => $companyId,
                'user_id' => $idAdmin,
                'estado' => 1
            ];
        }, $companiesId);
    }
    private function returnError($error)
    {
        return [
            'error' => $error->getMessage(),
            'status' => $error->getCode()
        ];
    }
}
