<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmTechosCodigo  implements IServicioPmTechosCodigos
{
    private String $tablaTechoCodigo, $tablaPmCodigos, $idCodigoDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPmCodigos $servicioPmCodigos;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioPmCodigos $servicioPmCodigos)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaTechoCodigo = tablas::getTablaClientePmTechosCodigos();
        $this->tablaPmCodigos = tablas::getTablaClientePmCodigos();
        $this->servicioPmCodigos = $servicioPmCodigos;
    }

    public function obtenerPmTechosCodigos()
    {
        try {
            $sql = "
            SELECT 
              pmc.*,
                pmcodigos.id idCodigo,
                pmcodigos.codigo codigoCodigo,
                pmcodigos.descripcion descripcionCodigo
            FROM $this->tablaTechoCodigo pmc
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

    public function crearPmTechosCodigo(array $entidadPmTechoCodigo)
    {
        try {

            $codigoEncontrado = $this->validarCodigoFk($this->desEncriptarKey(base64_decode($entidadPmTechoCodigo["pm_codigo_id"])));
            if ($codigoEncontrado) {
                return $codigoEncontrado;
            }
            $entidadPmTechoCodigo["pm_codigo_id"] = $this->idCodigoDesEncriptado;
            $this->repositoryDynamicsCrud->createInfo($this->tablaTechoCodigo, $entidadPmTechoCodigo);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function actualizarPmTechosCodigo(String $id, array $entidadPmTechoCodigo)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $productoEncontrado = $this->validarCodigoFk($this->desEncriptarKey(base64_decode($entidadPmTechoCodigo["pm_codigo_id"])));

            $calidadEncontrado = $this->validarTechoCodigo($id);

            if ($productoEncontrado || $calidadEncontrado) {
                return $productoEncontrado ?? $calidadEncontrado;
            }

            $entidadPmTechoCodigo["pm_codigo_id"] = $this->idCodigoDesEncriptado;

            $this->repositoryDynamicsCrud->updateInfo($this->tablaTechoCodigo, $entidadPmTechoCodigo, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmTechosCodigo(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $calidadEncontrado = $this->validarTechoCodigo($id);
            if ($calidadEncontrado) {
                return  $calidadEncontrado;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaTechoCodigo, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarEstadoPmTechosCodigo(String $id)
    {
        try {
            $id =  $this->desencriptarKey(base64_decode($id));
            $techoCodigoDb =  $this->obtenerPmTechosCodigoPorId($id);
            if (!$techoCodigoDb) {
                return response()->json(["Error" => "Techo de codigo no existente"], 404);
            }
            $nuevoEstado = !$techoCodigoDb[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaTechoCodigo, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["respuesta" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerPmTechosCodigoPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaTechoCodigo WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    private function validarCodigoFk(string $idProducto)
    {
        $productoDb = $this->servicioPmCodigos->validarCodigoPorId($idProducto);
        if ($productoDb) {
            return $productoDb;
        }
        $this->idCodigoDesEncriptado = $idProducto;
        return null;
    }
    public function validarTechoCodigo(string $idCalidad)
    {
        $calidadDb = $this->obtenerPmTechosCodigoPorId($idCalidad);
        if (count($calidadDb) == 0) {
            return response()->json(["Error" => "Techo de codigo no existente"], 404);
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
