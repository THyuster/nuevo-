<?php


namespace App\Utils\TransfersData\ModuloTesoreria;

use App\Data\Dtos\ModuloTesoreria\TesoreriaGruposConceptosDto;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Symfony\Component\HttpFoundation\Response;

class ServicioGruposConceptos implements IServicioGruposConceptos
{
    private String $tablaGruposConceptos;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    public function __construct() {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->tablaGruposConceptos= tablas::getTablaClienteTesoreriaGrupoConcepto();
    }

    public function obtenerGrupoConceptos() {
        try {
            
            $sql = "SELECT * FROM $this->tablaGruposConceptos";
            $gruposConceptos = $this->repositoryDynamicsCrud->sqlFunction($sql);
            return array_map(function ($grupo) {
                $grupo->id = base64_encode( $this->encriptarKey($grupo->id));
                return $grupo;
            }, $gruposConceptos);
        } catch (\Throwable $th) {
             return response()->json($th->getMessage(), $th->getCode());
        }
    }

    public function crearGrupoConceptos(TesoreriaGruposConceptosDto $TesoreriaConceptosDto) {
        try {
            $this->repositoryDynamicsCrud->createInfo($this->tablaGruposConceptos,$TesoreriaConceptosDto->toArray());
            return new Response("Registro creado exitosamente", Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
           return response()->json($th->getMessage(), $th->getCode());
        }
    }

    public function actualizarGrupoConceptos(TesoreriaGruposConceptosDto $tesoreriaGruposConceptosDto) {
        try {
            $idDesencriptado = $this->desencriptarKey(base64_decode($tesoreriaGruposConceptosDto->getId()));
            $this->buscarGrupoConceptoPorId( $idDesencriptado);
            $tesoreriaGruposConceptosDto->setId($idDesencriptado);
            $this->repositoryDynamicsCrud->updateInfo($this->tablaGruposConceptos, $tesoreriaGruposConceptosDto->toArray(), $idDesencriptado);
            return new Response("Registro actualizado exitosamente", Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
             return response()->json($th->getMessage(), $th->getCode());
        }
    }

    public function eliminarGrupoConceptos($id) {
        try {
            $idDesencriptado = $this->desencriptarKey(base64_decode($id));
            $this->buscarGrupoConceptoPorId( $idDesencriptado);
             $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaGruposConceptos, $idDesencriptado);
            return new Response("Registro eliminado exitosamente", Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }
    public function buscarGrupoConceptoPorId($id) {
    
        $sql = "SELECT * FROM $this->tablaGruposConceptos WHERE id = '$id'";
        $response =  $this->repositoryDynamicsCrud->sqlFunction($sql);
        if(!$response){
            throw  new \Exception("No encontro el grupo concepto", Response::HTTP_NOT_FOUND);
        }
        return $response;
    }

    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}