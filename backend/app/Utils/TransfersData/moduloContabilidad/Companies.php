<?php

namespace App\Utils\TransfersData\moduloContabilidad;

use App\Utils\Constantes\Erp\SqlClient;
use App\Utils\Constantes\ModuloContabilidad\SqlThird;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\Constantes\ModuloContabilidad\SqlFiscalYear;
use App\Utils\FileManager;
use App\Utils\MyFunctions;

use App\Utils\Repository\RepositoryDynamicsCrud;

class Companies
{

    protected $date, $fileManager, $myFunctions, $nameDataBase, $nameDBRelation;
    protected $repositoryDynamicsCrud, $sqlClient, $sqlCompanies, $sqlFiscalYear, $sqlThird;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->nameDataBase = "contabilidad_empresas";
        $this->nameDBRelation = "erp_relacion_empresas";

        $this->sqlThird = new SqlThird;
        $this->sqlClient = new SqlClient;
        $this->fileManager = new FileManager;
        $this->myFunctions = new MyFunctions;
        $this->sqlCompanies = new SqlCompanies;
        $this->sqlFiscalYear = new SqlFiscalYear;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    }

    public function create($request)
    {
        $data = $request->all();
        // $third = $this->myFunctions->extraerNumero($data['tercero_id']);
        $this->findNit($data['nit']);


        $this->fieldsUniques($data, $id = null);

        $clienteId = $this->myFunctions->extraerNumero($data['cliente_id']);
        $this->findClient($clienteId);
        // $this->validateRelationClientCompanie($clienteId);
        unset($data['cliente_id']);
        $data['ruta_imagen'] = $this->fileManager->PushImagen($request, 'contabilidad/empresa', "");
        // $data['tercero_id'] = $third;
        $data['estado'] = 1;
        $data['created_at'] = $this->date;
        $companieId = $this->repositoryDynamicsCrud->getRecordId($this->nameDataBase, $data);
        $dataClient = array("empresa_id" => $companieId, "cliente_id" => $clienteId);

        return $this->repositoryDynamicsCrud->createInfo($this->nameDBRelation, $dataClient);
    }

    public function update($id, $request)
    {
        try {
            $data = $request->all();
            $this->findNit($data['nit'], $id);
            $findCompanie = $this->findCompanieById($id);

            $relationCompanieClient = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_relacion_empresas WHERE empresa_id= $id");
            if (!$relationCompanieClient) {
                throw new \Exception('Relacion no encontrada', 404);
            }

            $idRelation = $relationCompanieClient[0]->id;
            $this->fieldsUniques($data, $id);
            $clienteId = $this->myFunctions->extraerNumero($data['cliente_id']);
            $this->findClient($clienteId);
            unset($data['cliente_id']);

            if ($request->hasFile("ruta_imagen")) {
                $pathImagen = $findCompanie[0]->ruta_imagen;
                if ($pathImagen) {
                    $this->fileManager->deleteImage($pathImagen);
                }
                $data['ruta_imagen'] = $this->fileManager->PushImagen($request, 'contabilidad/empresa', "");
            } else {
                $data['ruta_imagen'] = $findCompanie[0]->ruta_imagen;
            }

            $dataClient = array("cliente_id" => $clienteId);
            $this->repositoryDynamicsCrud->updateInfo($this->nameDBRelation, $dataClient, $idRelation);

            $data['updated_at'] = $this->date;
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function checkCompanies($idClient, $idsCompanies)
    {
        $sql = $this->sqlCompanies->findByIds($idClient, implode(",", $idsCompanies));

        $findCompanies = $this->repositoryDynamicsCrud->sqlFunction($sql);

        $response = array_diff($idsCompanies, array_column($findCompanies, 'id'));

        if ($response) {
            $notCompanies = implode(",", $response);
            throw new \Exception("Empresas no asociadas  $notCompanies", 404);
        }
        return $response;
    }

    public function updateStatus($id)
    {
        try {
            $findCompanie = $this->findCompanieById($id);

            $newStatus = array('estado' => !$findCompanie[0]->estado);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newStatus, $id);
        } catch (\Throwable $e) {
            return $e;
        }
    }

    public function delete($id)
    {

        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
        $findCompanie = $this->findCompanieById($id);
        $sql = $this->sqlFiscalYear->getSqlFiscalYearById($id);
        $getFiscarYear = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($getFiscarYear) {
            throw new \Exception('No puede eliminar la empresa porque tiene años fiscales registrados', 400);
        }
        $relationCompanieClient = $this->repositoryDynamicsCrud->sqlFunction(
            "SELECT * FROM erp_relacion_empresas WHERE empresa_id= $id"
        );
        if (!$relationCompanieClient) {
            throw new \Exception('Relacion no encontrada', 404);
        }
        $this->fileManager->deleteImage($findCompanie[0]->ruta_imagen);
        $idRelation = $relationCompanieClient[0]->id;

        $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDBRelation, $idRelation);
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }



    private function findNit($nit, $id = null)
    {
        $sql = ($id) ? $this->sqlCompanies->findDbByCompanieById($id, $nit)
            : $this->sqlCompanies->findDbByCompanie($nit);

        $response = $this->repositoryDynamicsCrud->sqlFunction($sql, 1);

        if ($response) {
            throw new \Exception('Nit ya registrado', 400);
        }
        return true;

    }



    private function fieldsUniques($data, $id)
    {
        $fields = [
            'razon_social',
            'direccion',
            'email',
        ];
        foreach ($fields as $field) {
            $value = strval($data[$field]);
            $query = ($id)
                ? $this->sqlCompanies->checkExistingRecordExcludingId($id, $field, $value)
                : $this->sqlCompanies->getSqlCheckData($field, $value);

            $verifiedData = $this->repositoryDynamicsCrud->sqlFunction($query);
            if ($verifiedData) {
                throw new \Exception("Ya existe un registro con el valor $value", 400);
            }
        }
    }



    public function findCompanieById($id)
    {
        $sql = $this->sqlCompanies->getCompanie($id);
        $findCompanie = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$findCompanie) {
            throw new \Exception('Empresa no existente', 404);
        }
        return $findCompanie;
    }

    private function findClient($id)
    {

        $sql = $this->sqlClient->getClient($id);
        $findClient = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$findClient) {
            throw new \Exception('Cliente no existente', 404);
        }
        return $findClient;
    }

    private function validateRelationClientCompanie($id)
    {
        $sql = $this->sqlCompanies->findRelationClientCompanie($id);
        $findClient = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($findClient) {
            throw new \Exception('Ya existe un grupo empresarial asociado a una empresa', 404);
        }
        return true;
    }
}