<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmCupos  implements IServicioPmCupos
{
    private String $tablaPmCupos, $tablaPmCodigos, $idCodigoDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPmCodigos $servicioPmCodigos;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPmCodigos $servicioPmCodigos)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaPmCupos = tablas::getTablaClientePmCupos();
        $this->tablaPmCodigos = tablas::getTablaClientePmCodigos();
        $this->servicioPmCodigos = $servicioPmCodigos;
    }

    public function obtenerPmCupos()
    {
        try {
            $sql = "
            SELECT 
              pmc.*,
                pmcodigos.id idCodigo,
                pmcodigos.codigo codigoCodigo,
                pmcodigos.descripcion descripcionCodigo
            FROM $this->tablaPmCupos pmc
            LEFT JOIN $this->tablaPmCodigos pmcodigos ON pmcodigos.id = pmc.pm_codigo_id
            ";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaPmCalidades = array_map(function ($cupo) {
                $cupo->id = base64_encode($this->encriptarKey($cupo->id));
                $cupo->codigo = (object)[
                    "id" => base64_encode($this->encriptarKey($cupo->idCodigo)),
                    "codigo" => $cupo->codigoCodigo,
                    "descripcion" => $cupo->descripcionCodigo
                ];
                unset(
                    $cupo->idCodigo,
                    $cupo->codigoCodigo,
                    $cupo->descripcionCodigo,
                    $cupo->pm_codigo_id
                );

                return $cupo;
            }, $resultadosDb);
            return response()->json(["datos" => $respuestaPmCalidades], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearPmCupo(array $entidadPmCupo)
    {
        try {

            $codigoEncontrado = $this->validarCodigoFk($this->desEncriptarKey(base64_decode($entidadPmCupo["pm_codigo_id"])));
            if ($codigoEncontrado) {
                return $codigoEncontrado;
            }
            $entidadPmCupo["pm_codigo_id"] = $this->idCodigoDesEncriptado;
            $this->repositoryDynamicsCrud->createInfo($this->tablaPmCupos, $entidadPmCupo);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function actualizarPmCupo(String $id, array $entidadPmCalidades)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $productoEncontrado = $this->validarCodigoFk($this->desEncriptarKey(base64_decode($entidadPmCalidades["pm_codigo_id"])));

            $calidadEncontrado = $this->validarCupo($id);

            if ($productoEncontrado || $calidadEncontrado) {
                return $productoEncontrado ?? $calidadEncontrado;
            }

            $entidadPmCalidades["pm_codigo_id"] = $this->idCodigoDesEncriptado;

            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmCupos, $entidadPmCalidades, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmCupo(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $calidadEncontrado = $this->validarCupo($id);
            if ($calidadEncontrado) {
                return  $calidadEncontrado;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaPmCupos, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarEstadoPmCupo(String $id)
    {
        try {
            $id =  $this->desencriptarKey(base64_decode($id));
            $cupoDb =  $this->obtenerPmCupoPorId($id);
            if (!$cupoDb) {
                return response()->json(["Error" => "Cupo no existente"], 404);
            }
            $nuevoEstado = !$cupoDb[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmCupos, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["respuesta" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerPmCupoPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaPmCupos WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function validarCodigoFk(string $idCodigo)
    {
        $codigoDb = $this->servicioPmCodigos->validarCodigoPorId($idCodigo);
        if ($codigoDb) {
            return $codigoDb;
        }
        $this->idCodigoDesEncriptado = $idCodigo;
        return null;
    }
    private function validarCupo(string $idCalidad)
    {
        $calidadDb = $this->obtenerPmCupoPorId($idCalidad);
        if (count($calidadDb) == 0) {
            return response()->json(["Error" => "Cupo no existente"], 404);
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
