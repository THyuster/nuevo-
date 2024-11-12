<?php

namespace App\Utils\TransfersData\moduloContabilidad;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ModuloContabilidad\SqlThird;
use App\Utils\MyFunctions;
use App\Utils\FileManager;


class Third
{
    protected $repositoryDynamicsCrud, $sqlThird, $nameDataBaseRelation;
    protected $date, $nameDataBase, $myFunctions, $fileManager;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->date = date("Y-m-d H:i:s");
        $this->sqlThird = new SqlThird;
        $this->nameDataBase = "contabilidad_terceros";
        $this->nameDataBaseRelation = "contabilidad_relacion_tipos_terceros";
        $this->fileManager = new FileManager;
        $this->myFunctions = new MyFunctions;
    }

    public function getThirds($tercerosModel)
    {
        $newArray = array();

        foreach ($tercerosModel as $tercero) {
            $identificacion = $tercero->identificacion;
            $encontrado = false;

            foreach ($newArray as $obj) {
                if ($obj->identificacion == $identificacion) {

                    $encontrado = true;
                    $obj->idRelacionTercero[] = $tercero->idRelacionTercero;
                    break;
                }
            }

            if (!$encontrado) {
                $tercero->idRelacionTercero = ($tercero->idRelacionTercero)  ? [$tercero->idRelacionTercero] : [];
                $newArray[] = $tercero;
            }
        }
        return $newArray;
    }

    public function create($request)
    {
        try {
            $data = $request->all();
            $this->findIdentification($data['identificacion'], false);

            $data['municipio'] = $this->myFunctions->extraerNumero($data['municipio']);
            $data['tipo_tercero_id'] =  json_decode($data['tipo_tercero_id'], true);
            if (count($data['tipo_tercero_id']) == 0) {
                throw new \Exception("Debe seleccionar al menos un tipo de tercero", 400);
            }
            if (isset($data['DV']) && !isset($data['empresa'])) {
                throw new \Exception("Debe digitar el nombre de la empresa", 400);
            }
            if (!isset($data['DV']) && !isset($data['nombre1']) && !isset($data['apellido1'])) {
                throw new \Exception("Debe diligenciar el nombre y el apellido", 400);
            }
            $thirds = $data['tipo_tercero_id'];
            $this->validateFks($thirds);

            unset($data['fecha_inactivo'], $data['tipo_tercero_id']);
            if ($request->hasFile("ruta_imagen")) {
                $data['ruta_imagen'] =
                    $this->fileManager->PushImagen($request, 'contabilidad/tercero', "ruta_imagen");
            } else {
                $data['ruta_imagen'] = "";
            }

            $entidadTercero = $this->dataMapper($data);

            $idThird = $this->repositoryDynamicsCrud->getRecordId($this->nameDataBase, $entidadTercero);
            $newThirds = $this->mapperFks($thirds, $idThird);

            return $this->repositoryDynamicsCrud->createInfo($this->nameDataBaseRelation, $newThirds);
        } catch (\Throwable $error) {
            throw new \Exception($error->getMessage(), 500);
        }
    }
    public function update($id, $request)
    {
        try {
            $data = $request->all();
            $findThird = $this->findThird($id);

            $this->findIdentification($data['identificacion'], $id);
            $data['municipio'] = $this->myFunctions->extraerNumero($data['municipio']);
            $data['tipo_tercero_id'] =  json_decode($data['tipo_tercero_id'], true);
            if (count($data['tipo_tercero_id']) == 0) {
                throw new \Exception("Debe seleccionar al menos un tipo de tercero", 400);
            }
            if (isset($data['DV']) && !isset($data['empresa'])) {
                throw new \Exception("Debe digitar el nombre de la empresa", 400);
            }
            if (!isset($data['DV']) && !isset($data['nombre1']) && !isset($data['apellido1'])) {
                throw new \Exception("Debe diligenciar el nombre y el apellido", 400);
            }
            $thirds = $data['tipo_tercero_id'];

            $this->validateFks($thirds);
            unset($data['fecha_inactivo'], $data['tipo_tercero'], $data['fecha_actualizacion']);

            $pathImagen = "";
            $responseImage = "";
            if ($request->hasFile("ruta_imagen")) {
                $pathImagen = $findThird[0]->ruta_imagen;
                if ($pathImagen) {
                    $this->fileManager->deleteImage($pathImagen);
                }
                $responseImage = $this->fileManager->pushImagen($request, 'contabilidad/tercero', "ruta_imagen");
                $data['ruta_imagen'] = $responseImage;
            } else {
                $data['ruta_imagen'] = $findThird[0]->ruta_imagen;
            }

            $entidadTercero = $this->dataMapper($data);
            $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $entidadTercero, $id);
            $this->deleteRelationshipTypesThirdParties($id);
            $addFks = $this->addODeletethirdParty($id, $thirds);
            $newThirds = $this->mapperFks($addFks, $id);
            $this->repositoryDynamicsCrud->createInfo($this->nameDataBaseRelation, $newThirds);

            return response()->json([json_encode("Registro actualizado exitosamente ")], 200);
        } catch (\Throwable $error) {
            throw new \Exception($error->getMessage(), 400);
        }
    }

    private function dataMapper($data)
    {
        return array(
            "apellido1" => strtoupper($data['apellido1']),
            "apellido2" => strtoupper(isset($data['apellido2']) ? $data['apellido2'] : ''),
            "created_at" => $this->date,
            "direccion" => isset($data['direccion']) ? $data['direccion'] : '',
            "DV" => isset($data['DV']) ? $data['DV'] : '',
            "email" => $data['email'],
            "fecha_nacimiento" => isset($data['fecha_nacimiento']) ? $data['fecha_nacimiento'] : null,
            "estado" => "1",
            "grupo_sanguineo_id" => isset($data['grupo_sanguineo']) ? $data['grupo_sanguineo'] : null,
            "identificacion" => $data['identificacion'],
            "movil" => $data['movil'],
            "municipio" => $data['municipio'],
            "naturaleza_juridica" => $data['naturaleza_juridica'],
            "nombre_completo" => strtoupper($this->joinNames($data)),
            "nombre1" => strtoupper($data['nombre1']),
            "nombre2" => strtoupper(isset($data['nombre2']) ? $data['nombre2'] : ''),
            "observacion" => isset($data['observacion']) ? $data['observacion'] : '',
            "empresa" => isset($data['empresa']) ? $data['empresa'] : '',
            "ruta_imagen" => $data['ruta_imagen'],
            "telefono_fijo" =>
            isset($data['telefono_fijo']) ? $data['telefono_fijo'] : null,
            "tipo_identificacion" => $data['tipo_identificacion'],
            "updated_at" => $this->date,
        );
    }

    public function delete($id)
    {

        $findThird = $this->findThird($id);
        $getFixedAsset = $this->getRelationsFixedAssets($id);

        if ($getFixedAsset) {
            throw new \Exception('No se puede eliminar el tecero porque existe un registro asociado en activos fijos', 400);
        }


        $this->fileManager->deleteImage(json_encode($findThird[0]->ruta_imagen));
        $this->deleteRelationshipTypesThirdParties($id);

        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    private function deleteRelationshipTypesThirdParties($id)
    {
        return $this->repositoryDynamicsCrud->sqlFunction($this->sqlThird->getSqlDeleteRelationsTypesThird($id));
    }


    private function findIdentification($identification, $id)
    {
        $sql = (!$id) ? $this->sqlThird->getSqlFindIdentification($identification)
            : $this->sqlThird->getIdentificationByIdDiferent($id, $identification);
        $identificationThird = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($identificationThird) {
            throw new \Exception('Identificacion existente', 400);
        }
        return $identificationThird;
    }

    public function updateStatus($id)
    {

        $thirdFind = $this->findThird($id);
        $estado = !$thirdFind[0]->estado;
        $data = array(
            'estado' => $estado,
            "updated_at" => $this->date
        );

        $data['fecha_inactivo'] = $estado ? null : $this->date;

        return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $data, $id);
    }

    private function findThird($id)
    {

        $findThird = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->nameDataBase WHERE id = $id");
        if (!$findThird) {
            throw new \Exception('Tercero no existente', 404);
        }

        return $findThird;
    }


    public function validarTerceroPorId($id)
    {
        $sql = "SELECT * FROM $this->nameDataBase WHERE id = '$id'";
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            return response()->json(['message' => 'Tercero no encontrado'], 404);
        }
        return null;
    }
    private function getRelationsFixedAssets($id)
    {
        $sql = $this->sqlThird->getRelationInFixedAsset($id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function joinNames(array $data)
    {
        return strtoupper($data['nombre1'] . ' ' . (isset($data['nombre2']) ? $data['nombre2'] : '') . ' ' . $data['apellido1'] . ' ' . (isset($data['apellido2']) ? $data['apellido2'] : ''));
    }

    private function validateFks($fks)
    {

        $joinFks = implode(",", $fks);
        $sql = "SELECT id FROM contabilidad_tipos_terceros WHERE id in ($joinFks)";
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        $fksFalses = array_diff($fks, array_column($response, "id"));
        if ($fksFalses) {
            throw new \Exception("Verificar los tipos de terceros", 400);
        }
        return $fks;
    }
    private function mapperFks($fks, $idThird)
    {
        return array_map(function ($fk) use ($idThird) {
            return [
                'tercero_id' => $idThird,
                'tipo_tercero_id' => $fk
            ];
        }, $fks);
    }

    private function addODeletethirdParty(int $id, array $fks)
    {
        $sql = "SELECT id FROM contabilidad_tipos_terceros WHERE id = " . $id;
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        $addFks = array_diff($fks, array_column($response, "id"));
        $deleteFks = array_diff(array_column($response, "id"), $fks);

        if ($deleteFks) {
            $joinFks = implode(",", $deleteFks);
            $sqlDelete = "DELETE FROM contabilidad_tipos_terceros WHERE id = $id AND tipo_tercero_id IN ($joinFks)";
            $this->repositoryDynamicsCrud->sqlFunction($sqlDelete);
        }
        return $addFks;
    }
}
