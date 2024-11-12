<?php

namespace App\Utils\TransfersData\Erp;

use App\Data\Dtos\Usuario\UsuarioCreateDTO;
use App\Data\Dtos\Usuario\UsuarioCreateRequestDTO;
use App\Utils\CatchToken;
use Illuminate\Support\Facades\Auth;
use App\Utils\Constantes\Erp\SqlUsers;
use App\Utils\Constantes\Erp\SqlClient;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\AdminGeneral\AdminServices;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\TransfersData\moduloContabilidad\Companies;
use App\Utils\TypesAdministrators;
use Throwable;

class Users
{


    protected $adminServices, $adminUsersServices, $repositoryDynamicsCrud;
    protected $sqlClient, $sqlUser, $servicesCompanies, $nameDBRelation, $catchToken;

    public function __construct()
    {
        $this->sqlClient = new SqlClient;
        $this->adminServices = new AdminServices;
        $this->adminUsersServices = new AdminUser;
        $this->catchToken = new CatchToken;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;

        $this->sqlUser = new SqlUsers;
        $this->servicesCompanies = new Companies;
        $this->nameDBRelation = "erp_relacion_user_empresas";
    }
    public function getUser()
    {
        return Auth::check() ? Auth::user() : "No logueado";
    }


    private function getIdClient()
    {
        $user = $this->getUser();
        $sql = $this->sqlClient->getIdClientByUser($user->id);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (!$response) {
            throw new \Exception('Usuario no encontrado ', 404);
        }
        return $response[0]->id;
    }

    public function create(UsuarioCreateRequestDTO $usuarioCreateDTO)
    {
        try {

            $idClient = $this->getIdClient();
            $idCompanie = $this->catchToken->Claims();

            $this->servicesCompanies->checkCompanies($idClient, array($idCompanie));

            if (filter_var($usuarioCreateDTO->email, FILTER_VALIDATE_EMAIL)) {
            } else {
                throw new \Exception("Correo no valido", 201);
            }
            $this->validatechargeType($usuarioCreateDTO->tipo_cargo);

            $usuarioCreateDTO->tipo_administrador = 3;
            $usuarioCreateDTO->cliente_id = $idClient;
            // return $usuarioCreateDTO->toArray();
            $userId = $this->adminServices->createUser($usuarioCreateDTO->toArray());
            $this->adminUsersServices->validateCompanyAssignment(array($idCompanie));

            $newRelation = array('empresa_id' => $idCompanie, 'user_id' => $userId, 'estado' => 1);
            return $this->repositoryDynamicsCrud->createInfo($this->nameDBRelation, $newRelation);
        } catch (Throwable $error) {
            throw new \Exception($error->getMessage(), 500);
            // throw $error;
        }
    }

    
    public function update($idAdmin, $updatedUser)
    {
        try {
            $response = $this->getIdClient();

            
            $updatedUser['cliente_id'] = $response;

            if (filter_var($updatedUser['email'], FILTER_VALIDATE_EMAIL)) {
            } else {
                throw new \Exception("Correo no valido", 201);
            }

            if (isset($updatedUser['companiesId'])) {

                $idCompanies = $this->catchToken->Claims();
                $this->servicesCompanies->checkCompanies($response[0]->id, array($idCompanies));

                unset($updatedUser['companiesId']);
                $sql = $this->sqlUser->updateRelationsCompanie($idCompanies, $idAdmin);
                $this->repositoryDynamicsCrud->sqlFunction($sql);
            }
           return $this->adminServices->updateUser($idAdmin, $updatedUser);
        } catch (\Throwable $error) {
            throw $error;
        }
    }


    public function delete($id)
    {


        try {
            $this->deleteRelationsCompanie($id);
            $this->deleteRelationsClient($id);
            $this->adminServices->deleteUser($id);
        } catch (\Throwable $error) {
            throw $error;
        }
    }




    public function arrayCompanies($idRecord, $idsCompanies)
    {
        $response = array_map(function ($idCompanie) use ($idRecord) {
            return array(
                'empresa_id' => $idCompanie,
                'user_id' => $idRecord,
                'estado' => 1
            );
        }, $idsCompanies);
        return $response;
    }


    public function statusUpdate($id)
    {
        try {
            return $this->adminServices->statusUpdateUser($id);
        } catch (\Throwable $error) {
            return $this->returnError($error);
        }
    }

    private function returnError($error)
    {
        return [
            'error' => $error->getMessage(),
            'status' => $error->getCode()
        ];
    }

    private function deleteRelationsCompanie($id)
    {
        $sql = $this->sqlUser->deleteRelationClientCompanie($id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    private function deleteRelationsClient($id)
    {
        $sql = $this->sqlUser->deleteRelationsCompanie($id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function validatechargeType($tipoCargo)
    {
        $sql = "SELECT * FROM tipo_cargo WHERE id = $tipoCargo";
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new \Exception("Tipo de cargo no existente");
        }
        return $response;
    }
}
