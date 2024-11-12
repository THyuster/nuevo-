<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioTarifaTraslado implements IServicioTarifasTraslados
{
    private String  $tablaPatio, $tablaTarifaTraslado, $idPatioLlegadaDesEncriptado, $idPatioSalidaDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPatios $servicioPatios;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPatios $servicioPatios)
    {
        $this->tablaPatio = tablas::getTablaClientePmPatios();
        $this->tablaTarifaTraslado = tablas::getTablaClientePmTarifasTraslados();
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->servicioPatios = $servicioPatios;
    }

    public function obtenerTarifasTraslados()
    {
        $query = "
        SELECT 
        pmtt.id idTraslado,
        pmtt.codigo codigoTraslado,
        pmtt.descripcion descripcionTraslado,
        pmtt.estado estadoTraslado,
        pmp.id idPatioOrigen,
        pmp.codigo codigoPatioOrigen,
        pmp.descripcion descripcionPatioOrigen,
        pmp.propio propioPatioOrigen,
        pmp2.id idPatioLlegada,
        pmp2.codigo codigoPatioLlegada,
        pmp2.descripcion descripcionPatioLlegada,
        pmp2.propio propioPatioLlegada,
        pmtt.id idTraslado
        FROM $this->tablaTarifaTraslado pmtt
        INNER JOIN $this->tablaPatio pmp ON pmp.id = pmtt.patio_origen_id
        INNER JOIN $this->tablaPatio pmp2 ON pmp2.id = pmtt.patio_destino_id
        ";
        $tarifasDb =  $this->repositoryDynamicsCrud->sqlFunction($query);
        return array_map(function ($tarifa) {
            $tarifa->id = base64_encode($this->encriptarKey($tarifa->idTraslado));

            $tarifa->patioLlegada = (object)[
                "id" => base64_encode($this->encriptarKey($tarifa->idPatioLlegada)),
                "codigo" => $tarifa->codigoPatioLlegada,
                "descripcion" => $tarifa->descripcionPatioLlegada,
                "propio" => $tarifa->propioPatioLlegada
            ];
            $tarifa->patioOrigen = (object)[
                "id" => base64_encode($this->encriptarKey($tarifa->idPatioOrigen)),
                "codigo" => $tarifa->codigoPatioOrigen,
                "descripcion" => $tarifa->descripcionPatioOrigen,
                "propio" => $tarifa->propioPatioOrigen
            ];

            unset(
                $tarifa->idTraslado,
                $tarifa->idPatioLlegada,
                $tarifa->codigoPatioLlegada,
                $tarifa->descripcionPatioLlegada,
                $tarifa->propioPatioLlegada,
                $tarifa->idPatioOrigen,
                $tarifa->codigoPatioOrigen,
                $tarifa->descripcionPatioOrigen,
                $tarifa->propioPatioOrigen
            );
            return $tarifa;
        }, $tarifasDb);
    }



    public function crearTarifaTraslado(array $data)
    {
        try {
            $validarFks = $this->validarFks($data);
            if ($validarFks) {
                return $validarFks;
            }
            $nuevaBodega = $this->mapperTarifaTraslado($data);
            $this->repositoryDynamicsCrud->createInfo($this->tablaTarifaTraslado, $nuevaBodega);
            return response()->json(['message' => 'Tarifa de traslado creada correctamente'], 200);
        } catch (\Throwable $th) {
            // throw new \Exception($th->getMessage());
            return response()->json(['message' => 'Error al crear la Tarifa de traslado'], 500);
        }
    }

    public function actualizarTarifaTraslado($id, $data)
    {
        try {
            $id = $this->desencriptarKey(base64_decode($id));
            $encontrarTarifaTraslado = $this->obtenerTarifaTrasladoId($id);
            $validarFks = $this->validarFks($data);
            if (!$encontrarTarifaTraslado || $validarFks) {
                return $encontrarTarifaTraslado ?? $validarFks;
            }
            $nuevaTarifaTraslado = $this->mapperTarifaTraslado($data);
            $this->repositoryDynamicsCrud->updateInfo($this->tablaTarifaTraslado, $nuevaTarifaTraslado, $id);
            return response()->json(['message' => 'Traslado de tarifa actualizada correctamente'], 200);
        } catch (\Throwable $th) {
            // throw new \Exception($th->getMessage());
            return response()->json(['message' => 'Error al actualizar la Traslado de tarifa'], 500);
        }
    }

    public function eliminarTarifaTraslado($id)
    {
        try {
            $id = $this->desencriptarKey(base64_decode($id));
            $encontrarTarifaTraslado = $this->obtenerTarifaTrasladoId($id);
            if (!$encontrarTarifaTraslado) {
                return $encontrarTarifaTraslado;
            }
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaTarifaTraslado, $id);
            return response()->json(['message' => 'Traslado de tarifa eliminada correctamente'], 200);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
            // return response()->json(['message' => 'Error al crear el patio'], 500);
        }
    }
    public function obtenerTarifaTrasladoId($id)
    {
        $query = "SELECT * FROM $this->tablaTarifaTraslado WHERE id = '$id'";

        $tarifaTrasladoDb = $this->repositoryDynamicsCrud->sqlFunction($query);
        if (!$tarifaTrasladoDb) {
            return false;
        }
        return $tarifaTrasladoDb;
    }

    public function actualizarEstadoTarifaTraslado(string $id)
    {
        try {
            $id =  $this->desencriptarKey(base64_decode($id));
            $tarifaTrasladoDb =  $this->obtenerTarifaTrasladoId($id);
            if (!$tarifaTrasladoDb) {
                return response()->json(['message' => 'Traslado de tarifa no se encuentra'], 404);
            }
            $nuevoEstado = !$tarifaTrasladoDb[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaTarifaTraslado, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["respuesta" => $th->getMessage()], $th->getCode());
        }
    }

    private function mapperTarifaTraslado(array $data)
    {
        return [
            'codigo' => $data['codigo'],
            'descripcion' => $data['descripcion'],
            'patio_origen_id' => $this->idPatioSalidaDesEncriptado,
            'patio_destino_id' => $this->idPatioLlegadaDesEncriptado
        ];
    }

    private function validarFks(array $data)
    {

        $this->idPatioSalidaDesEncriptado = $this->desencriptarKey(base64_decode($data['patio_origen_id']));
        $this->idPatioLlegadaDesEncriptado = $this->desencriptarKey(base64_decode($data['patio_destino_id']));



        $patioSalidaId = $this->validarPatioFk($this->idPatioSalidaDesEncriptado);
        $patioLlegadaId = $this->validarPatioFk($this->idPatioLlegadaDesEncriptado);

        if ($patioSalidaId != null || $patioLlegadaId != null) {
            return $patioSalidaId ?? $patioLlegadaId;
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

    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}
