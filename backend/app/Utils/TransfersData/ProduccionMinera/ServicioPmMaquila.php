<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmMaquila  implements IServicioPmMaquila
{
    private String $tablaMaquila, $tablaRelacionCodigoMaquila;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaMaquila = tablas::getTablaClientePmMaquila();
        $this->tablaRelacionCodigoMaquila = tablas::getTablaClientePmRelacionCodigoMaquila();
    }
    public function obtenerMaquilas()
    {
        try {
            $sql = "SELECT * FROM $this->tablaMaquila";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaZonas = array_map(function ($zona) {
                $zona->id = base64_encode($this->encriptarKey($zona->id));
                return $zona;
            }, $resultadosDb);
            $respuestaZonas;
            return  response()->json(["datos" => $respuestaZonas], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearMaquila(array $entidadZona)
    {
        try {
            $this->repositoryDynamicsCrud->createInfo($this->tablaMaquila, $entidadZona);
            return  response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarMaquila(String $id, array $entidadZona)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $zonaEncontrada = $this->validarMaquila($id);
            if ($zonaEncontrada) {
                return  $zonaEncontrada;
            }
            $this->repositoryDynamicsCrud->updateInfo($this->tablaMaquila, $entidadZona, $id);
            return  response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarMaquila(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $zonaEncontrada = $this->validarMaquila($id);
            if ($zonaEncontrada) {
                return  $zonaEncontrada;
            }
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaMaquila, $id);
            return  response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function validarMaquila(string $idProducto)
    {
        $productoDb = $this->obteneMaquilaPorId($idProducto);
        if (count($productoDb) == 0) {
            return response()->json(["Error" => "Maquila no existente"], 404);
        }

        return null;
    }

    private function validarPmCodigos()
    {
    }

    public function obteneMaquilaPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaMaquila WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }

    private function desEncriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}
