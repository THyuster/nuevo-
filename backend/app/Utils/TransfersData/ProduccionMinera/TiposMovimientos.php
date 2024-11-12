<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;

use App\Utils\Constantes\ProduccionMinera\SqlTiposMovimientos;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;


class TiposMovimientos  implements IServicioTipoMovimientos
{
    private String $tablaTipoMovimiento, $tablaTipoMovimientoRelacion, $tablaTipoCodigoPm, $tablaTipoPatioPm;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioTipoCodigo $iServicioTipoCodigo;
    private IServicioTipoPatios $iServicioTipoPatio;

    private $codigoSalidaDesEncriptado, $codigoLlegadaDesEncriptado, $tipoPatioLlegadaDesEncriptado, $tipoPatioSalidaDesEncriptado;

    private SqlTiposMovimientos $sqlTiposMovimientos;
    public function __construct(
        RepositoryDynamicsCrud $repositoryDynamicsCrud,
        IServicioTipoCodigo  $iServicioTipoCodigo,
        IServicioTipoPatios $iServicioTipoPatio
    ) {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaTipoMovimiento = tablas::getTablaClientePmTiposMovimientos();
        $this->tablaTipoMovimientoRelacion = tablas::getTablaClientePmTiposMovimientosRelacion();
        $this->tablaTipoCodigoPm = tablas::getTablaClientePmTiposCodigos();
        $this->tablaTipoPatioPm = tablas::getTablaClientePmTiposPatios();
        $this->iServicioTipoCodigo =  $iServicioTipoCodigo;
        $this->iServicioTipoPatio =  $iServicioTipoPatio;
        $this->sqlTiposMovimientos = new SqlTiposMovimientos;
    }
    public function obtenerTipoMovimientos()
    {

        try {
            $nuevosDatos = [];
            $sql = $this->sqlTiposMovimientos->obtenerTipoMovimientos();
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);

            foreach ($resultadosDb as $codigo) {
                $idEncriptado = base64_encode($this->encriptarKey($codigo->idMovimiento));
                if (!array_search($idEncriptado, json_decode(json_encode($nuevosDatos), true))) {
                    $nuevoMovimiento = (object)[
                        "idMovimiento" =>  $idEncriptado,
                        "descripcionMovimiento" => $codigo->descripcionMovimiento,
                        "codigoMovimiento" => $codigo->codigoMovimiento,
                        "estadoMovimiento" => $codigo->estadoMovimiento,
                    ];
                    // print_r($codigo->idTipoCodigoSalida);
                    // exit();
                    $nuevoMovimiento->movimientos[] = [
                        "tipo_codigo_salida" => [
                            "id" => base64_encode($this->encriptarKey($codigo->idTipoCodigoSalida)),
                            "codigo" => $codigo->codigoTipoCodigoSalida,
                            "descripcion" => $codigo->descripcionTipoCodigoSalida
                        ],
                        "tipo_codigo_llegada" => [
                            "id" => base64_encode($this->encriptarKey($codigo->idTipoCodigoLlegada)),
                            "codigo" => $codigo->codigoTipoCodigoLlegada,
                            "descripcion" => $codigo->descripcionTipoCodigoLlegada
                        ],
                        "tipo_patio_salida" => [
                            "id" => base64_encode($this->encriptarKey($codigo->idTipoPatioSalida)),
                            "descripcion" => $codigo->descripcionTipoPatioSalida
                        ],
                        "tipo_patio_llegada" => [
                            "id" => base64_encode($this->encriptarKey($codigo->idTipoPatioLlegada)),
                            "descripcion" => $codigo->descripcionTipoPatioLlegada
                        ]
                    ];
                    array_push($nuevosDatos, $nuevoMovimiento);
                }
            }
            return  response()->json(["datos" => $nuevosDatos], 200);
        } catch (\Throwable $th) {
            // throw new \Exception($th->getMessage());
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], 400);
        }
    }
    public function crearTiposMovimiento(array $tipoMovimiento)
    {
        try {
            $sonValidos = $this->validarCodigos($tipoMovimiento);
            $codigosNoRegistrados = $this->validarTipoMovimientoUnicos();
            if ($sonValidos || $codigosNoRegistrados) {
                return $sonValidos ?? $codigosNoRegistrados;
            }

            $guardarMovimiento = $this->mapearEntidadMovimiento((object) $tipoMovimiento);
            $moviendoId =  $this->repositoryDynamicsCrud->getRecordId($this->tablaTipoMovimiento, $guardarMovimiento);

            $guardarMovimientoRelacion = $this->mapearEntidadMovimientoRelacion($moviendoId, (object) $tipoMovimiento);
            $this->repositoryDynamicsCrud->createInfo($this->tablaTipoMovimientoRelacion, $guardarMovimientoRelacion);

            return response()->json(["respuesta" => "Registro creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["respuesta" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarTiposMovimiento(String $id,  array $tipoMovimiento)
    {
        try {

            $id = $this->desencriptarKey(base64_decode($id));
            $movimientoConRelacion = $this->validarTipoMovimientoConRelacion($id);
            if (!$movimientoConRelacion) {
                return response()->json(["respuesta" => "Error al tratar de actualizar el registro"], 400);
            }

            $sonValidos = $this->validarCodigos($tipoMovimiento);
            $codigosNoRegistrados = $this->validarTipoMovimientoUnicos();
            if ($sonValidos || $codigosNoRegistrados) {
                return $sonValidos ?? $codigosNoRegistrados;
            }
            $guardarMovimiento = $this->mapearEntidadMovimiento((object) $tipoMovimiento);
            $this->repositoryDynamicsCrud->updateInfo($this->tablaTipoMovimiento, $guardarMovimiento, $id);

            $guardarMovimientoRelacion = $this->mapearEntidadMovimientoRelacion($id, (object) $tipoMovimiento);
            $idRelacion = $movimientoConRelacion[0]->idRelacion;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaTipoMovimientoRelacion, $guardarMovimientoRelacion, $idRelacion);

            return response()->json(["respuesta" => $guardarMovimientoRelacion], 200);
        } catch (\Throwable $th) {
            // throw new \Exception($th->getMessage());
            return response()->json(["respuesta" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarEstadoTipoMovimiento(String $id)
    {
        try {
            $id = $this->desencriptarKey(base64_decode($id));
            $response = $this->validarTipoMovimientoId($id);
            if (!$response) {
                return response()->json(["respuesta" => "Error al tratar de actualizar el registro"], 400);
            }

            $nuevoEstado = !$response[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaTipoMovimiento, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["respuesta" => $th->getMessage()], $th->getCode());
        }
    }

    public function validarTipoMovimientoId(String $id)
    {
        $sql = $this->sqlTiposMovimientos->obtenerTipoMovimiento($id);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            return false;
        }

        return $response;
    }
    private function validarTipoMovimientoConRelacion($id)
    {
        $sql = $this->sqlTiposMovimientos->obtenerTipoMovimientoConRelacion($id);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            return false;
        }
        return $response;
    }
    private function validarTipoCodigo(String $idCodigo)
    {
        $response =  $this->iServicioTipoCodigo->obtenerCodigoPorId($idCodigo);
        if ($response) {
            return null;
        }
        return response()->json("Codigo no encontrado", 404);
    }
    private function validarTipoPatio(String $idCodigo)
    {
        $response =  $this->iServicioTipoPatio->obtenerPatioPorId($idCodigo);
        if ($response) {
            return null;
        }
        return response()->json("Patio no encontrado", 404);
    }

    private function validarCodigos($tipoMovimiento)
    {

        $this->codigoSalidaDesEncriptado = $this->desencriptarKey(base64_decode($tipoMovimiento['tipo_codigo_salida_id']));
        $this->codigoLlegadaDesEncriptado = $this->desencriptarKey(base64_decode($tipoMovimiento['tipo_codigo_llegada_id']));
        $this->tipoPatioLlegadaDesEncriptado =  $this->desencriptarKey(base64_decode($tipoMovimiento['tipo_patio_llegada_id']));
        $this->tipoPatioSalidaDesEncriptado = $this->desencriptarKey(base64_decode($tipoMovimiento['tipo_patio_salida_id']));


        $codigoSalida = $this->validarTipoCodigo($this->codigoSalidaDesEncriptado);
        $codigoLlegada = $this->validarTipoCodigo($this->codigoLlegadaDesEncriptado);
        $tipoPatioLlegada = $this->validarTipoPatio($this->tipoPatioLlegadaDesEncriptado);
        $tipoPatioSalida = $this->validarTipoPatio($this->tipoPatioSalidaDesEncriptado);

        if ($codigoSalida != null || $codigoLlegada != null || $tipoPatioLlegada != null || $tipoPatioSalida != null) {
            return $codigoSalida ?? $codigoLlegada ?? $tipoPatioLlegada ?? $tipoPatioSalida;
        }
        return null;
    }

    private function mapearEntidadMovimiento($entidad)
    {
        return [
            "codigo" => $entidad->codigo,
            "descripcion" => $entidad->descripcion,
        ];
    }
    private function mapearEntidadMovimientoRelacion($moviendoId, $entidad)
    {
        return [
            "tipo_movimiento_id" => $moviendoId,
            "tipo_codigo_salida_id" => $this->codigoSalidaDesEncriptado,
            "tipo_codigo_llegada_id" => $this->codigoLlegadaDesEncriptado,
            "tipo_patio_salida_id" =>  $this->tipoPatioSalidaDesEncriptado,
            "tipo_patio_llegada_id" => $this->tipoPatioLlegadaDesEncriptado,
        ];
    }

    private function validarTipoMovimientoUnicos()
    {
        $sql = $this->sqlTiposMovimientos->obtenerTipoMovimientosRelacion(
            $this->codigoSalidaDesEncriptado,
            $this->codigoLlegadaDesEncriptado,
            $this->tipoPatioLlegadaDesEncriptado,
            $this->tipoPatioSalidaDesEncriptado
        );

        $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (count($resultadosDb) >= 1) {
            return response()->json(["respuesta" => "Tipo de movimiento ya rgistrado"], 400);
        }

        return null;
    }
    public function elimininarTipoMovimiento(string $id)
    {
        $id = $this->desencriptarKey(base64_decode($id));
        $sql =  $this->sqlTiposMovimientos->eliminarTipoMovimientoRelacion($id);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            return response()->json(["respuesta" => "Error al tratar de eliminar el registro"], 400);
        }
        return response()->json(["respuesta" => "Registro eliminado exitosamente"], 200);
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


// if( array_search($idDesEncriptado, $nuevosDatos)){
//     $nuevosDatos->movimientos[]=[
//         "id"=>$codigo->idMovimiento,
//         "descripcion"=>$codigo->descripcionMovimiento,
//         "codigo"=>$codigo->codigoMovimiento,
//         "tipo_codigo_salida"=>[
//             "id"=>base64_encode($this->encriptarKey($codigo->tipo_codigo_salida_id)),
//             "descripcion"=>$codigo->descripcionTipoCodigoSalida
//         ],
//         "tipo_codigo_llegada"=>[
//             "id"=>base64_encode($this->encriptarKey($codigo->tipo_codigo_llegada_id)),
//             "descripcion"=>$codigo->descripcionTipoCodigoLlegada
//         ],
//         "tipo_patio_salida"=>[
//             "id"=>base64_encode($this->encriptarKey($codigo->tipo_patio_salida_id)),
//             "descripcion"=>$codigo->descripcionTipoPatioSalida
//         ],
//         "tipo_patio_llegada"=>[
//             "id"=>base64_encode($this->encriptarKey($codigo->tipo_patio_llegada_id)),
//             "descripcion"=>$codigo->descripcionTipoPatioLlegada
//         ]
//     ];

// }