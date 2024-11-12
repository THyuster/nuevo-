<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioBodega implements IServicioBodega
{
    private String $tablaBodega, $tablaPatio, $tablaInventarioBodega, $patioIdDesEncriptado, $inventarioBodegaId;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPatios $servicioPatios;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPatios $servicioPatios)
    {
        $this->tablaBodega = tablas::getTablaClientePmBodegas();
        $this->tablaPatio = tablas::getTablaClientePmPatios();
        $this->tablaInventarioBodega = tablas::getTablaClienteInventarioBodega();
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->servicioPatios = $servicioPatios;
    }

    public function obtenerBodegas()
    {
        $query = "
        SELECT 
        pmb.id idPmBodega,
        pmb.codigo  codigoPmBodega,
        pmb.descripcion descripcionPmBodega,
        pmb.estado estadoPmBodega,
        pmp.id idPatio,
        pmp.codigo codigoPatio,
        pmp.descripcion descripcionPatio,
        ib.id idInventarioBodega,
        ib.codigo codigoInventarioBodega,
        ib.descripcion descripcionInvetarioBodega
        FROM $this->tablaBodega pmb
        INNER JOIN $this->tablaPatio pmp ON pmp.id = pmb.patio_id
        INNER JOIN $this->tablaInventarioBodega ib ON ib.id = pmb.inventario_bodega_id
        ";
        $BodegasDb =  $this->repositoryDynamicsCrud->sqlFunction($query);
        return array_map(function ($bodega) {
            $bodega->id = base64_encode($this->encriptarKey($bodega->idPmBodega));
            $bodega->codigo = $bodega->codigoPmBodega;
            $bodega->descripcion = $bodega->descripcionPmBodega;
            $bodega->estado = $bodega->estadoPmBodega;
            $bodega->patio = (object)[
                "id" => base64_encode($this->encriptarKey($bodega->idPatio)),
                "codigo" => $bodega->codigoPatio,
                "descripcion" => $bodega->descripcionPatio
            ];
            $bodega->inventarioBodegas = (object)[
                "id" => $bodega->idInventarioBodega,
                "codigo" => $bodega->codigoInventarioBodega,
                "descripcion" => $bodega->descripcionInvetarioBodega
            ];
            unset(
                $bodega->idPmBodega,
                $bodega->codigoPmBodega,
                $bodega->descripcionPmBodega,
                $bodega->estadoPmBodega,
                $bodega->idPatio,
                $bodega->codigoPatio,
                $bodega->descripcionPatio,
                $bodega->idInventarioBodega,
                $bodega->codigoInventarioBodega,
                $bodega->descripcionInvetarioBodega
            );
            return $bodega;
        }, $BodegasDb);
    }



    public function crearBodegas(array $data)
    {
        try {
            $validarFks = $this->validarFks($data);
            if ($validarFks) {
                return $validarFks;
            }
            $nuevaBodega = $this->mapperBodega($data);
            $this->repositoryDynamicsCrud->createInfo($this->tablaBodega, $nuevaBodega);
            return response()->json(['message' => 'Bodega creada correctamente'], 200);
        } catch (\Throwable $th) {
            // throw new \Exception($th->getMessage());
            return response()->json(['message' => 'Error al crear la bodega'], 500);
        }
    }

    public function actualizarBodegas($id, $data)
    {
        try {
            $id = $this->desencriptarKey(base64_decode($id));
            $encontrarBodega = $this->obtenerBodegasPorId($id);
            $validarFks = $this->validarFks($data);
            if (!$encontrarBodega || $validarFks) {
                return $encontrarBodega ?? $validarFks;
            }
            $nuevaBodega = $this->mapperBodega($data);
            $this->repositoryDynamicsCrud->updateInfo($this->tablaBodega, $nuevaBodega, $id);
            return response()->json(['message' => 'Bodega actualizada correctamente'], 200);
        } catch (\Throwable $th) {
            // throw new \Exception($th->getMessage());
            return response()->json(['message' => 'Error al actualizar la bodega'], 500);
        }
    }

    public function eliminarBodegas($id)
    {
        try {
            $id = $this->desencriptarKey(base64_decode($id));
            $encontrarBodega = $this->obtenerBodegasPorId($id);
            if (!$encontrarBodega) {
                return $encontrarBodega;
            }
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaBodega, $id);
            return response()->json(['message' => 'Bodega eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
            // return response()->json(['message' => 'Error al crear el patio'], 500);
        }
    }
    public function obtenerBodegasPorId($id)
    {
        $query = "SELECT * FROM $this->tablaBodega WHERE id = '$id'";

        $BodegaDb = $this->repositoryDynamicsCrud->sqlFunction($query);
        if (!$BodegaDb) {
            return false;
        }
        return $BodegaDb;
    }

    public function actualizarEstadoBodegas(string $id)
    {
        try {
            $id =  $this->desencriptarKey(base64_decode($id));
            $BodegaDb =  $this->obtenerBodegasPorId($id);
            if (!$BodegaDb) {
                return response()->json(['message' => 'La bodega no se encuentra'], 404);
            }
            $nuevoEstado = !$BodegaDb[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaBodega, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["respuesta" => $th->getMessage()], $th->getCode());
        }
    }

    private function mapperBodega(array $data)
    {
        return [
            'codigo' => $data['codigo'],
            'descripcion' => $data['descripcion'],
            'patio_id' => $this->patioIdDesEncriptado,
            'inventario_bodega_id' => $this->inventarioBodegaId
        ];
    }

    private function validarFks(array $data)
    {

        $this->patioIdDesEncriptado = $this->desencriptarKey(base64_decode($data['patio_id']));
        $this->inventarioBodegaId = $data['inventario_bodega_id'];

        $inventarioBodegaId = $this->validarInventarioBodegaFk($this->inventarioBodegaId);
        $patioId = $this->validarPatioFk($this->patioIdDesEncriptado);

        if ($inventarioBodegaId != null || $patioId != null) {
            return $inventarioBodegaId ?? $patioId;
        }
        return null;
    }
    private function validarPatioFk(String $id)
    {
        $patioDb = $this->servicioPatios->obtenerPatioPorId($id);
        if (!$patioDb) {
            return response()->json(['message' => 'El patio no existe'], 404);
        }
        return null;
    }
    private function validarInventarioBodegaFk(String $id)
    {

        $query = "SELECT * FROM $this->tablaInventarioBodega WHERE id = '$id'";

        $inventarioBodegaDb = $this->repositoryDynamicsCrud->sqlFunction($query);
        if (!$inventarioBodegaDb) {
            return response()->json(['message' => 'El inventario de bodega no existe'], 404);
        }
        return null;
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
