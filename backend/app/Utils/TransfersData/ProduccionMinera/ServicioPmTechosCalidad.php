<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmTechosCalidad  implements IServicioPmTechosCalidades
{
    private String $tablaPmTechosCalidad, $tablaCalidad, $idCalidadDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPmCalidades $iServicioCalidad;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPmCalidades $iServicioCalidad)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaPmTechosCalidad = tablas::getTablaClientePmTechosCalidad();
        $this->tablaCalidad = tablas::getTablaClientePmCalidades();
        $this->iServicioCalidad = $iServicioCalidad;
    }

    public function obtenerPmTechosCalidades()
    {
        try {
            $sql = "
            SELECT 
            pmtc.*,
            pmc.id as idCalidad,
            pmc.codigo as codigoCalidad,
            pmc.descripcion as descripcionCalidad
            FROM $this->tablaPmTechosCalidad pmtc
            LEFT JOIN $this->tablaCalidad pmc ON pmc.id = pmtc.pm_tipo_calidad_id
            ";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaPmCalidades = array_map(function ($techoCalidad) {
                $techoCalidad->id = base64_encode($this->encriptarKey($techoCalidad->id));
                $techoCalidad->calidad = (object)[
                    "id" => base64_encode($this->encriptarKey($techoCalidad->idCalidad)),
                    "codigo" => $techoCalidad->codigoCalidad,
                    "descripcion" => $techoCalidad->descripcionCalidad
                ];
                unset($techoCalidad->pm_tipo_calidad_id, $techoCalidad->idCalidad, $techoCalidad->codigoCalidad, $techoCalidad->descripcionCalidad);

                return $techoCalidad;
            }, $resultadosDb);
            return response()->json(["datos" => $respuestaPmCalidades], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearPmTechoCalidad(array $entidadPmTechoCalidad)
    {
        try {

            $calidadEncontrada = $this->validarCalidadFk($this->desEncriptarKey(base64_decode($entidadPmTechoCalidad["pm_tipo_calidad_id"])));
            if ($calidadEncontrada) {
                return $calidadEncontrada;
            }
            $entidadPmTechoCalidad["pm_tipo_calidad_id"] = $this->idCalidadDesEncriptado;
            $this->repositoryDynamicsCrud->createInfo($this->tablaPmTechosCalidad, $entidadPmTechoCalidad);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function actualizarPmTechoCalidad(String $id, array $entidadPmCalidades)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $productoEncontrado = $this->validarCalidadFk($this->desEncriptarKey(base64_decode($entidadPmCalidades["pm_tipo_calidad_id"])));

            $calidadEncontrado = $this->validarTechoCalidad($id);

            if ($productoEncontrado || $calidadEncontrado) {
                return $productoEncontrado ?? $calidadEncontrado;
            }

            $entidadPmCalidades["pm_tipo_calidad_id"] = $this->idCalidadDesEncriptado;

            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmTechosCalidad, $entidadPmCalidades, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmTechoCalidad(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $calidadEncontrado = $this->validarTechoCalidad($id);
            if ($calidadEncontrado) {
                return  $calidadEncontrado;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaPmTechosCalidad, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarEstadoPmTechoCalidad(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $calidadEncontrado = $this->obtenerPmTechoCalidadPorId($id);
            if (!$calidadEncontrado) {
                return response()->json(["Error" => "Techo calidad no existente"], 404);
            }

            $nuevoEstado = !$calidadEncontrado[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmTechosCalidad, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerPmTechoCalidadPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaPmTechosCalidad WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function validarCalidadFk(string $idCalidad)
    {
        $productoDb = $this->iServicioCalidad->obtenerPmCalidadPorId($idCalidad);
        if (count($productoDb) == 0) {
            return response()->json(["Error" => "Calidad  no existente"], 404);
        }
        $this->idCalidadDesEncriptado = $idCalidad;
        return null;
    }
    private function validarTechoCalidad(string $idCalidad)
    {
        $calidadDb = $this->obtenerPmTechoCalidadPorId($idCalidad);
        if (count($calidadDb) == 0) {
            return response()->json(["Error" => "Techo calidad no existente"], 404);
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
