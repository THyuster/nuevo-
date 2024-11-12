<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmGranulometrias  implements IServicioPmGranulometrias
{
    private String $tablaPmGranulometria, $tablaCalidad, $idCalidadDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPmCalidades $servicioPmCalidades;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPmCalidades $servicioPmCalidades)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaPmGranulometria = tablas::getTablaClientePmGranulometrias();
        $this->tablaCalidad = tablas::getTablaClientePmCalidades();
        $this->servicioPmCalidades = $servicioPmCalidades;
    }

    public function obtenerPmGranulometrias()
    {
        try {
            $sql = "
            SELECT 
            pmg.id idGranulometria,
            pmg.codigo codigoGranulometria,
            pmg.descripcion descripcionGranulometria,
            pmc.id idCalidad,
            pmc.codigo codigoCalidad,
            pmc.descripcion descripcionCalidad

            FROM $this->tablaPmGranulometria pmg
            LEFT JOIN $this->tablaCalidad pmc ON pmc.id = pmg.pm_calidad_id
            ";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaPmCalidades = array_map(function ($granulometria) {
                $granulometria->id = base64_encode($this->encriptarKey($granulometria->idGranulometria));
                $granulometria->codigo = $granulometria->codigoGranulometria;
                $granulometria->descripcion = $granulometria->descripcionGranulometria;
                $granulometria->calidad = (object)[
                    "id" => base64_encode($this->encriptarKey($granulometria->idCalidad)),
                    "codigo" => $granulometria->codigoCalidad,
                    "descripcion" => $granulometria->descripcionCalidad
                ];
                unset(
                    $granulometria->idGranulometria,
                    $granulometria->codigoGranulometria,
                    $granulometria->descripcionGranulometria,
                    $granulometria->idCalidad,
                    $granulometria->codigoCalidad,
                    $granulometria->descripcionCalidad,
                );
                return $granulometria;
            }, $resultadosDb);
            return response()->json(["datos" => $respuestaPmCalidades], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage() || 400], $th->getCode());
        }
    }

    public function crearPmGranulometria(array $entidadPmGranulometrias)
    {
        try {

            $granulometriaEncontrado = $this->validarCalidad($this->desEncriptarKey(base64_decode($entidadPmGranulometrias["pm_calidad_id"])));
            if ($granulometriaEncontrado) {
                return $granulometriaEncontrado;
            }
            $entidadPmGranulometrias["pm_calidad_id"] = $this->idCalidadDesEncriptado;
            $this->repositoryDynamicsCrud->createInfo($this->tablaPmGranulometria, $entidadPmGranulometrias);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function actualizarPmGranulometria(String $id, array $entidadPmGranulometrias)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $calidadEncontrada = $this->validarCalidad($this->desEncriptarKey(base64_decode($entidadPmGranulometrias["pm_calidad_id"])));
            $granulometriaEncontrado = $this->validarGranulometria($id);

            if ($calidadEncontrada || $granulometriaEncontrado) {
                return $calidadEncontrada ?? $granulometriaEncontrado;
            }

            $entidadPmGranulometrias["pm_calidad_id"] = $this->idCalidadDesEncriptado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmGranulometria, $entidadPmGranulometrias, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmGranulometria(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $granulometriaEncontrado = $this->validarGranulometria($id);
            if ($granulometriaEncontrado) {
                return  $granulometriaEncontrado;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaPmGranulometria, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerPmGranulometriaPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaPmGranulometria WHERE id = '$id'";
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
    private function validarGranulometria(string $idCalidad)
    {
        $calidadDb = $this->obtenerPmGranulometriaPorId($idCalidad);
        if (count($calidadDb) == 0) {
            return response()->json(["Error" => "Granulometria no existente"], 404);
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
