<?php

namespace App\Utils\TransfersData\AdminGeneral;

use App\Data\Dtos\Empresa\RelacionEmpresaDTO;
use App\Data\Dtos\Usuario\UsuarioCreateDTO;
use App\Data\Dtos\Usuario\UsuarioCreateRequestDTO;
use App\Data\Dtos\Usuario\UsuarioDTO;
use App\Utils\Constantes\Erp\SqlAdmin;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\Client;
use App\Utils\TypesAdministrators;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminServices
{


    private $date;
    protected $nameDataBase;
    protected $repositoryDynamicsCrud;
    protected $sqlAdmin;
    protected $serviceClient;
    protected $nameDataBaseRelation;
    protected $sqlClient;
    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->nameDataBase = "users";
        $this->nameDataBaseRelation = "erp_relacion_user_cliente";
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->sqlAdmin = new SqlAdmin;
        $this->serviceClient = new Client;
    }



    public function createUser($newUser)
    {

        try {
            $usuarioCreateDTO = UsuarioCreateRequestDTO::fromArray($newUser);
            $this->mailWithAndWithoutId($id = null, $usuarioCreateDTO->email);

            $clientsId = $usuarioCreateDTO->cliente_id;
            $this->serviceClient->findClient($clientsId);

            $usuarioCreateDTO->password = $this->passwordEncrypt($usuarioCreateDTO->password);
            $usuarioCreateDTO->administrador = "SI";
            $usuarioCreateDTO->estado = 'ACTIVO';
            $usuarioDTO = UsuarioDTO::fromArray($usuarioCreateDTO->toArray());

            $idAdmin = $this->repositoryDynamicsCrud->getRecordId($this->nameDataBase, $usuarioDTO->toArray());
            $relacionEmpresDTo = new RelacionEmpresaDTO($clientsId, $idAdmin);
            $this->repositoryDynamicsCrud->createInfo($this->nameDataBaseRelation, $relacionEmpresDTo->toArray());
            return $idAdmin;
        } catch (\Throwable $error) {
            throw $error;
        }
    }
    public function getUser()
    {
        return (Auth::check()) ? Auth::user() : false;
    }




    public function updateUser($idAdmin, $updatedUser)
    {
        try {

            $this->findAdmin($idAdmin);
        
            if (isset($updatedUser['email'])) {
                $this->mailWithAndWithoutId($idAdmin, $updatedUser['email']);
            }
            $updatedUser['updated_at'] = $this->date;

            if (isset($updatedUser['password'])) {
                $updatedUser['password'] = $this->passwordEncrypt($updatedUser['password']);
            }

            if (isset($updatedUser['tipo_administrador'])) {
                if ($updatedUser['tipo_administrador'] == TypesAdministrators::SUPER_ADMIN) {
                    throw new \Exception("No tiene permisos para modificar a super Admin  ", 403);
                }
            }
            if (isset($updatedUser['cliente_id'])) {
                $clientsId = $updatedUser['cliente_id'];
                $this->serviceClient->findClient($clientsId);
                $sql = $this->sqlAdmin->getSqlUpdateRelation($clientsId, $idAdmin);

                $this->repositoryDynamicsCrud->sqlFunction($sql);
                unset($updatedUser['cliente_id']);
            }
            return  $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $updatedUser, $idAdmin);

        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function verifyPermission($idAmin, $idRelation)
    {

        $sql = $this->sqlAdmin->getSqlRealtionUserClient($idAmin, $idRelation);

        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (empty($response)) {
            throw new \Exception("No puede realizar acciones de un grupo empresarial al cual no pertenece admin services ", 403);
        }
    }

    public function deleteUser($idAdmin)
    {
        try {

            $user = $this->getUser();
            $this->findAdmin($idAdmin);

            $this->verifyPermission($user->id, $idAdmin);
            $response = $this->repositoryDynamicsCrud->sqlFunction($this->sqlAdmin->deleteById($idAdmin));

            return $response == 1 ? 'Eliminado' : false;
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function statusUpdateUser($id)
    {
        try {
            $client = $this->findAdmin($id);
            $newStatus = ($client[0]->estado == 'ACTIVO') ? 'INACTIVO' : 'ACTIVO';
            $updateStatus = array('estado' => $newStatus);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $updateStatus, $id);
        } catch (\Throwable $error) {
            return $this->returnError($error);
        }
    }

    private function mailWithAndWithoutId($id, $email)
    {
        $sql = ($id) ?
            $this->sqlAdmin->getSqldifferentMail($id, $email) :
            $this->sqlAdmin->getEmail($email);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($response) {
            throw new \Exception('Correo existente', 400);
        }
        return $response;
    }
    private function passwordEncrypt($password)
    {
        return Hash::make($password);
    }

    public function findClient($id)
    {
        return $this->serviceClient->findClient($id);
    }

    private function arrayRelation($clientsId, $idAdmin)
    {
        return [
            'cliente_id' => $clientsId,
            'user_id' => $idAdmin
        ];
    }

    public function findAdmin($id)
    {
        $sql = $this->sqlAdmin->getAdmin($id);
        return $this->findRecord($sql, "Admin no encontrado", 404);
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