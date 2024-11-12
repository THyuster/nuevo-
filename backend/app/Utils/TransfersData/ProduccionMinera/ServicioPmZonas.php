<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmZonas  implements IServicioPmZonas
{
    private String $tablaZona;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaZona = tablas::getTablaClientePmZona();
    }
    public function obtenerZonas()
    {
        try {
            $sql = "SELECT * FROM $this->tablaZona";
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

    public function crearZona(array $entidadZona)
    {
        try {
            $this->repositoryDynamicsCrud->createInfo($this->tablaZona, $entidadZona);
            return  response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarZona(String $id, array $entidadZona)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $zonaEncontrada = $this->validarZona($id);
            if ($zonaEncontrada) {
                return  $zonaEncontrada;
            }
            $this->repositoryDynamicsCrud->updateInfo($this->tablaZona, $entidadZona, $id);
            return  response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarZona(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $zonaEncontrada = $this->validarZona($id);
            if ($zonaEncontrada) {
                return  $zonaEncontrada;
            }
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaZona, $id);
            return  response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function validarZona(string $idProducto)
    {
        $productoDb = $this->obteneZonaPorId($idProducto);
        if (count($productoDb) == 0) {
            return response()->json(["Error" => "Zona no existente"], 404);
        }

        return null;
    }

    public function obteneZonaPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaZona WHERE id = '$id'";
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
