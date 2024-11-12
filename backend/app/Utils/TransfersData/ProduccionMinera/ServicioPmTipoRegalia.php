<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmTipoRegalia  implements IServicioPmTipoRegalia
{
    private String $tablaPmTiPoRegalia, $tablaCalidades, $idCalidadDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPmCalidades $servicioPmCalidades;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPmCalidades $servicioPmCalidades)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaPmTiPoRegalia = tablas::getTablaClientePmTipoRegalia();
        $this->tablaCalidades = tablas::getTablaClientePmCalidades();
        $this->servicioPmCalidades = $servicioPmCalidades;
    }

    public function obtenerPmTipoRegalia()
    {
        try {
            $sql = "
            SELECT 
             pmtr.id idTipoRegalia,
             pmtr.codigo codigoTipoRegalia,
             pmtr.descripcion descripcionTipoRegalia,
             pmc.id idCalidad,
             pmc.codigo codigoCalidad,
             pmc.descripcion descripcionCalidad
            FROM $this->tablaPmTiPoRegalia pmtr
            LEFT JOIN $this->tablaCalidades pmc ON pmc.id = pmtr.pm_calidad_id
            ";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaTipoRegalias = array_map(function ($tipo) {
                $tipo->id = base64_encode($this->encriptarKey($tipo->idTipoRegalia));
                $tipo->codigo = $tipo->codigoTipoRegalia;
                $tipo->descripcion = $tipo->descripcionTipoRegalia;
                $tipo->calidad = (object)[
                    "id" => base64_encode($this->encriptarKey($tipo->idCalidad)),
                    "codigo" => $tipo->codigoCalidad,
                    "descripcion" => $tipo->descripcionCalidad
                ];
                unset(
                    $tipo->idTipoRegalia,
                    $tipo->codigoTipoRegalia,
                    $tipo->descripcionTipoRegalia,
                    $tipo->idCalidad,
                    $tipo->codigoCalidad,
                    $tipo->descripcionCalidad
                );
                return $tipo;
            }, $resultadosDb);
            return response()->json(["datos" => $respuestaTipoRegalias], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearPmTipoRegalia(array $entidadPmTipoRegalia)
    {
        try {

            $calidadEncontrada = $this->validarCalidad($this->desEncriptarKey(base64_decode($entidadPmTipoRegalia["pm_calidad_id"])));
            if ($calidadEncontrada) {
                return $calidadEncontrada;
            }
            $entidadPmTipoRegalia["pm_calidad_id"] = $this->idCalidadDesEncriptado;
            $this->repositoryDynamicsCrud->createInfo($this->tablaPmTiPoRegalia, $entidadPmTipoRegalia);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function actualizarPmTipoRegalia(String $id, array $entidadPmTipoRegalia)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $productoEncontrado = $this->validarCalidad($this->desEncriptarKey(base64_decode($entidadPmTipoRegalia["pm_calidad_id"])));

            $calidadEncontrado = $this->validarTipoRegalia($id);

            if ($productoEncontrado || $calidadEncontrado) {
                return $productoEncontrado ?? $calidadEncontrado;
            }

            $entidadPmTipoRegalia["pm_calidad_id"] = $this->idCalidadDesEncriptado;

            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmTiPoRegalia, $entidadPmTipoRegalia, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmTipoRegalia(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $tipoRegaliaEncontrado = $this->validarTipoRegalia($id);
            if ($tipoRegaliaEncontrado) {
                return  $tipoRegaliaEncontrado;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaPmTiPoRegalia, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarEstadoTipoRegalia(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $tipoRegaliaEncontrado = $this->obtenerPmTipoRegaliaPorId($id);
            if (!$tipoRegaliaEncontrado) {
                return response()->json(["Error" => "Tipo regalia no existente"], 404);
            }

            $nuevoEstado = !$tipoRegaliaEncontrado[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmTiPoRegalia, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerPmTipoRegaliaPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaPmTiPoRegalia WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function validarCalidad(string $idCalidad)
    {
        $productoDb = $this->servicioPmCalidades->obtenerPmCalidadPorId($idCalidad);
        if (count($productoDb) == 0) {
            return response()->json(["Error" => "Calidad no existente"], 404);
        }
        $this->idCalidadDesEncriptado = $idCalidad;
        return null;
    }
    public function validarTipoRegalia(string $idTipoRegalia)
    {
        $tipoRegaliaDb = $this->obtenerPmTipoRegaliaPorId($idTipoRegalia);
        if (count($tipoRegaliaDb) == 0) {
            return response()->json(["Error" => "Tipo regalia no existente"], 404);
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
