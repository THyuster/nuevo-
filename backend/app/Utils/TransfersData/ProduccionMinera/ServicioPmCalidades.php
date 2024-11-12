<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmCalidades  implements IServicioPmCalidades
{
    private String $tablaPmCalidades, $tablaPoductos, $idProductoDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPmProductos $servicioPmProductos;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPmProductos $servicioPmProductos)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaPmCalidades = tablas::getTablaClientePmCalidades();
        $this->tablaPoductos = tablas::getTablaClientePmProductos();
        $this->servicioPmProductos = $servicioPmProductos;
    }

    public function obtenerPmCalidades()
    {
        try {
            $sql = "
            SELECT 
            pmc.id idCalidad,
            pmc.codigo codigoCalidad,
            pmc.descripcion descripcionCalidad,
            pmp.id idProducto,
            pmp.codigo codigoProducto,
            pmp.descripcion descripcionProducto
            FROM $this->tablaPmCalidades pmc
            LEFT JOIN $this->tablaPoductos pmp ON pmp.id = pmc.pm_producto_id
            ";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaPmCalidades = array_map(function ($calidad) {
                $calidad->idCalidad = base64_encode($this->encriptarKey($calidad->idCalidad));
                $calidad->idProducto = base64_encode($this->encriptarKey($calidad->idProducto));
                return $calidad;
            }, $resultadosDb);
            return response()->json(["datos" => $respuestaPmCalidades], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearPmCalidad(array $entidadPmCalidades)
    {
        try {

            $productoEncontrado = $this->validarProducto($this->desEncriptarKey(base64_decode($entidadPmCalidades["pm_producto_id"])));
            if ($productoEncontrado) {
                return $productoEncontrado;
            }
            $entidadPmCalidades["pm_producto_id"] = $this->idProductoDesEncriptado;
            $this->repositoryDynamicsCrud->createInfo($this->tablaPmCalidades, $entidadPmCalidades);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function actualizarPmCalidad(String $id, array $entidadPmCalidades)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $productoEncontrado = $this->validarProducto($this->desEncriptarKey(base64_decode($entidadPmCalidades["pm_producto_id"])));

            $calidadEncontrado = $this->validarCalidad($id);

            if ($productoEncontrado || $calidadEncontrado) {
                return $productoEncontrado ?? $calidadEncontrado;
            }

            $entidadPmCalidades["pm_producto_id"] = $this->idProductoDesEncriptado;

            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmCalidades, $entidadPmCalidades, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmCalidad(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $calidadEncontrado = $this->validarCalidad($id);
            if ($calidadEncontrado) {
                return  $calidadEncontrado;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaPmCalidades, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerPmCalidadPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaPmCalidades WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function validarProducto(string $idProducto)
    {
        $productoDb = $this->servicioPmProductos->obteneProdutoPorId($idProducto);
        if (count($productoDb) == 0) {
            return response()->json(["Error" => "El producto no existe"], 404);
        }
        $this->idProductoDesEncriptado = $idProducto;
        return null;
    }
    private function validarCalidad(string $idCalidad)
    {
        $calidadDb = $this->obtenerPmCalidadPorId($idCalidad);
        if (count($calidadDb) == 0) {
            return response()->json(["Error" => "Calidad no existente"], 404);
        }

        return null;
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
