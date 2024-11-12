<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmProductos  implements IServicioPmProductos
{
    private String $tablaProductos;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaProductos = tablas::getTablaClientePmProductos();
    }
    public function obtenerProduto()
    {
        try {
            $sql = "SELECT * FROM $this->tablaProductos";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaProductos = array_map(function ($producto) {
                $producto->id = base64_encode($this->encriptarKey($producto->id));
                return $producto;
            }, $resultadosDb);
            $respuestaProductos;
            return  response()->json(["datos" => $respuestaProductos], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearProduto(array $entidadProducto)
    {
        try {
            $this->repositoryDynamicsCrud->createInfo($this->tablaProductos, $entidadProducto);
            return  response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarProduto(String $id, array $entidadProducto)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $productoEncontrado = $this->validarProducto($id);
            if ($productoEncontrado) {
                return  $productoEncontrado;
            }
            $this->repositoryDynamicsCrud->updateInfo($this->tablaProductos, $entidadProducto, $id);
            return  response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarProduto(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $productoEncontrado = $this->validarProducto($id);
            if ($productoEncontrado) {
                return  $productoEncontrado;
            }
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaProductos, $id);
            return  response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    private function validarProducto(string $idProducto)
    {
        $productoDb = $this->obteneProdutoPorId($idProducto);
        if (count($productoDb) == 0) {
            return response()->json(["Error" => "Producto no existente"], 404);
        }

        return null;
    }

    public function obteneProdutoPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaProductos WHERE id = '$id'";
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
