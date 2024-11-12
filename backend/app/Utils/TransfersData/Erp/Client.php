<?php

namespace App\Utils\TransfersData\Erp;

use App\Utils\FileManager;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\Erp\SqlClient;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\Constantes\ModuloContabilidad\SqlThird;
use Illuminate\Support\Facades\Auth;
use App\Utils\MyFunctions;
use App\Utils\TypesAdministrators;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class Client
{

    private $repositoryDynamicsCrud, $companiesRelationship, $date, $nameDataBase;

    protected $sqlClient, $sqlThird, $myFunctions, $fileManager, $sqlCompanies;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->nameDataBase = "erp_grupo_empresarial";
        $this->companiesRelationship = "erp_relacion_user_cliente";
        $this->sqlThird = new SqlThird;
        $this->sqlClient = new SqlClient;
        $this->sqlCompanies = new SqlCompanies;

        $this->fileManager = new FileManager;
        $this->myFunctions = new MyFunctions;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    }

    public function getUser()
    {
        return Auth::check() ? Auth::user() : false;
    }
    public function validatePermission()
    {
        $user = $this->getUser();
        $adminType = $user->tipo_administrador;

        if ($adminType > TypesAdministrators::SUPER_ADMIN) {
            throw new Exception(__('messages.permissionDeniedMessage'), Response::HTTP_UNAUTHORIZED);
        }
        return true;
    }
    public function create($request)
    {
        try {
            $this->validatePermission();
            $newClient = $request->all();
            $this->findNit($newClient['nit']);

            $response = $this->findData($id = null, $newClient);
            if ($response) {
                throw new Exception(__('messages.existingDataMessage') . " " . json_encode($response), 400);
            }

            $newClient['estado'] = 1;
            $newClient['created_at'] = $this->date;
            $newClient['ruta_imagen'] = $this->fileManager->PushImagen($request, 'erp/cliente', "");
            $idNewClient = $this->repositoryDynamicsCrud->getRecordId($this->nameDataBase, $newClient);
            $newDataRelation = array('user_id' => Auth::user()->id, 'cliente_id' => $idNewClient);

            return $this->repositoryDynamicsCrud->createInfo($this->companiesRelationship, $newDataRelation);
        } catch (\Throwable $error) {
            throw $error;
        }
    }


    public function update($id, $request)
    {
        try {
            $this->validatePermission();
            $data = $request->all();
            $getClient = $this->findClient($id);
            $this->findNit($data['nit'], $id);
            $response = $this->findData($id, $data);
            if ($response) {
                throw new \Exception(__('messages.existingDataMessage') . " " . json_encode($response), 400);
            }

            if ($request->hasFile("ruta_imagen")) {
                $pathImagen = $getClient[0]->ruta_imagen;
                if ($pathImagen) {
                    $this->fileManager->deleteImage($pathImagen);
                }
                $data['ruta_imagen'] = $this->fileManager->PushImagen($request, 'erp/cliente', "");
            } else {
                $data['ruta_imagen'] = $getClient[0]->ruta_imagen;
            }
            $data['updated_at'] = $this->date;

            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function delete($id)
    {
        try {
            $this->validatePermission();
            $getClient = $this->findClient($id);

            $sql = "DELETE FROM erp_relacion_user_cliente WHERE cliente_id = '$id'";
            $this->repositoryDynamicsCrud->sqlFunction($sql);

            $this->fileManager->deleteImage($getClient[0]->ruta_imagen);
            return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function statusUpdate($id)
    {
        try {
            $this->validatePermission();
            $client = $this->findClient($id);
            $newStatus = array('estado' => !$client[0]->estado);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newStatus, $id);
        } catch (\Throwable $error) {
            return $this->returnError($error);
        }
    }


    public function findClient($id)
    {

        $sql = $this->sqlClient->getClient($id);
        $getClient = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (empty($getClient)) {
            throw new Exception(__("messages.nonexistentClientErrorMessage"), Response::HTTP_NOT_FOUND);
        }
        return $getClient;
    }

    private function findData($id, $data)
    {
        $sql = ($id)
            ? $this->sqlClient->getDifferentCode($id, $data)
            : $this->sqlClient->getCodigo($data);


        $findedData = $this->repositoryDynamicsCrud->sqlFunction($sql);
        $arrayData = array(
            "nit" => $data["nit"],
            "telefono" => $data["telefono"],
            "direccion" => $data["direccion"],
            "codigo" => $data["codigo"],
        );
        if (!empty($findedData)) {
            $findJsonDeco = json_decode(json_encode($findedData[0]));
            $datadDeco = json_decode(json_encode($arrayData));

            $newObject = [];

            foreach ($findJsonDeco as $key => $value) {
                if ($datadDeco->$key == $value) {
                    $newObject[$key] = $value;
                }
            }
            return $newObject;
        }
        return;
    }

    private function returnError($error)
    {
        return [
            'error' => $error->getMessage(),
            'status' => $error->getCode()
        ];
    }
    private function findNit($nit, $id = null)
    {
        $sql = ($id) ? $this->sqlClient->findDbByClientById($id, $nit)
            : $this->sqlCompanies->findDbByCompanie($nit);

        $response = $this->repositoryDynamicsCrud->sqlFunction($sql, 1);

        if ($response) {
            throw new Exception(__('messages.duplicateNitErrorMessage'), Response::HTTP_CONFLICT);
        }
        return true;
    }
}
