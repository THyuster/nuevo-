<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmTarifaRegalia  implements IServicioPmTarifaRegalia
{
    private String $tablaPmTipoRegalia, $tablaTarifaRegalia, $idTipoRegaliaDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPmTipoRegalia $servicioPmTipoRegalia;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPmTipoRegalia $servicioPmTipoRegalia)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaTarifaRegalia = tablas::getTablaClientePmTarifaRegalia();
        $this->tablaPmTipoRegalia = tablas::getTablaClientePmTipoRegalia();
        $this->servicioPmTipoRegalia = $servicioPmTipoRegalia;
    }

    public function obtenerPmTarifaRegalia()
    {
        try {
            $sql = "
            SELECT 
             pmtarifaRegalia.id idTarifaRegalia,
             pmtarifaRegalia.fecha_inicio,
             pmtarifaRegalia.fecha_fin,
             pmtarifaRegalia.valor,
             pmtipoRegalia.id idTipo,
             pmtipoRegalia.codigo codigoTipo,
             pmtipoRegalia.descripcion descripcionTipo
            FROM $this->tablaTarifaRegalia pmtarifaRegalia
            LEFT JOIN  $this->tablaPmTipoRegalia pmtipoRegalia ON pmtipoRegalia.id = pmtarifaRegalia.pm_tipo_regalia_id
            ";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaPmCalidades = array_map(function ($tarifa) {
                $tarifa->id = base64_encode($this->encriptarKey($tarifa->idTarifaRegalia));

                $tarifa->tipoRegalia = (object)[
                    "id" => base64_encode($this->encriptarKey($tarifa->idTipo)),
                    "codigo" => $tarifa->codigoTipo,
                    "descripcion" => $tarifa->descripcionTipo
                ];
                unset(
                    $tarifa->idTarifaRegalia,

                    $tarifa->idTipo,
                    $tarifa->codigoTipo,
                    $tarifa->descripcionTipo
                );
                return $tarifa;
            }, $resultadosDb);
            return response()->json(["datos" => $respuestaPmCalidades], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearPmTarifaRegalia(array $entidadTarifaRegalia)
    {
        try {

            $tarifaRegaliaEncontrado = $this->validarTipoRegalia($this->desEncriptarKey(base64_decode($entidadTarifaRegalia["pm_tipo_regalia_id"])));
            if ($tarifaRegaliaEncontrado) {
                return $tarifaRegaliaEncontrado;
            }
            $entidadTarifaRegalia["pm_tipo_regalia_id"] = $this->idTipoRegaliaDesEncriptado;
            $this->repositoryDynamicsCrud->createInfo($this->tablaTarifaRegalia, $entidadTarifaRegalia);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function actualizarPmTarifaRegalia(String $id, array $entidadTarifaRegalia)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $tarifaRegaliaEncontrado = $this->validarTarifaRegalia($id);
            $tipoRegaliaEncontrada = $this->validarTipoRegalia($this->desEncriptarKey(base64_decode($entidadTarifaRegalia["pm_tipo_regalia_id"])));

            if ($tipoRegaliaEncontrada || $tarifaRegaliaEncontrado) {
                return $tipoRegaliaEncontrada ?? $tarifaRegaliaEncontrado;
            }

            $entidadTarifaRegalia["pm_tipo_regalia_id"] = $this->idTipoRegaliaDesEncriptado;

            $this->repositoryDynamicsCrud->updateInfo($this->tablaTarifaRegalia, $entidadTarifaRegalia, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmTarifaRegalia(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $tarifaRegaliaEncontrada = $this->validarTarifaRegalia($id);
            if ($tarifaRegaliaEncontrada) {
                return  $tarifaRegaliaEncontrada;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaTarifaRegalia, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarEstadoPmTarifaRegalia(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $tarifaRegaliaEncontrada = $this->obtenerPmTarifaRegaliaPorId($id);
            if (!$tarifaRegaliaEncontrada) {
                return response()->json(["Error" => "Tarifa regalia no existente"], 404);
            }
            $nuevoEstado = !$tarifaRegaliaEncontrada[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaTarifaRegalia, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerPmTarifaRegaliaPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaTarifaRegalia WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function validarTipoRegalia(string $idProducto)
    {
        $tipoRegaliaDb = $this->servicioPmTipoRegalia->obtenerPmTipoRegaliaPorId($idProducto);
        if (count($tipoRegaliaDb) == 0) {
            return response()->json(["Error" => "Tipo Regalia no existente"], 404);
        }
        $this->idTipoRegaliaDesEncriptado = $idProducto;
        return null;
    }
    private function validarTarifaRegalia(string $idTarifa)
    {
        $tarifaDb = $this->obtenerPmTarifaRegaliaPorId($idTarifa);
        if (count($tarifaDb) == 0) {
            return response()->json(["Error" => "Tarifa regalia no existente"], 404);
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
