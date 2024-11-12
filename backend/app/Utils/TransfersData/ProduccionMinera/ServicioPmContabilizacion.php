<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPmContabilizacion  implements IServicioPmContabilizacion
{
    private String $tablaPmContabilizacion, $tablaTiposMovimientos, $tablaCalidad, $idTipoMovimientoDesEncriptado, $idCalidadDesEncriptado;

    private String $idCuentaDbMaterialDesEncriptado, $idCuentaCrMaterialDesEncriptado, $idCuentaDbFleteDesEncriptado, $idCuentaCrFleteDesEncriptado;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioTipoMovimientos $iservicioTipoMovimientos;
    private IServicioPmCalidades $iServicioPmCalidades;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioTipoMovimientos $iservicioTipoMovimientos,  IServicioPmCalidades $iServicioPmCalidades)
    {
        $this->tablaCalidad = tablas::getTablaClientePmCalidades();
        $this->tablaTiposMovimientos = tablas::getTablaClientePmTiposMovimientos();
        $this->tablaPmContabilizacion = tablas::getTablaClientePmContabilizacion();

        $this->iServicioPmCalidades = $iServicioPmCalidades;
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->iservicioTipoMovimientos = $iservicioTipoMovimientos;
    }

    public function obtenerPmContabilizaciones()
    {
        try {
            $sql = "
            SELECT 
            pmcontabilizacion.id idContabilizacion,
            pmtm.id idTipoMovimiento,
            pmtm.codigo codigoTipoMovimiento,
            pmtm.descripcion descripcionTipoMovimiento,
            pmc.id idCalidad,
            pmc.codigo codigoCalidad,
            pmc.descripcion descripcionCalidad
            FROM $this->tablaPmContabilizacion pmcontabilizacion
            LEFT JOIN $this->tablaCalidad pmc ON pmc.id = pmcontabilizacion.pm_calidad_id 
            LEFT JOIN $this->tablaTiposMovimientos pmtm ON pmtm.id = pmcontabilizacion.pm_tipo_movimiento_id 
            ";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaPmCalidades = array_map(function ($calidad) {
                $calidad->id = base64_encode($this->encriptarKey($calidad->idContabilizacion));
                $calidad->tipoMovimiento = (object)[
                    "id" => base64_encode($this->encriptarKey($calidad->idTipoMovimiento)),
                    "codigo" => $calidad->codigoTipoMovimiento,
                    "descripcion" => $calidad->descripcionTipoMovimiento
                ];
                $calidad->calidad = (object)[
                    "id" => base64_encode($this->encriptarKey($calidad->idCalidad)),
                    "codigo" => $calidad->codigoCalidad,
                    "descripcion" => $calidad->descripcionCalidad
                ];
                unset(
                    $calidad->idContabilizacion,
                    $calidad->idTipoMovimiento,
                    $calidad->codigoTipoMovimiento,
                    $calidad->descripcionTipoMovimiento,
                    $calidad->idCalidad,
                    $calidad->codigoCalidad,
                    $calidad->descripcionCalidad,
                );
                return $calidad;
            }, $resultadosDb);
            return response()->json(["datos" => $respuestaPmCalidades], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearPmContabilizacion(array $entidadContabilizacion)
    {
        try {
            $fksValidadas = $this->validarFks($entidadContabilizacion);
            if ($fksValidadas != null) {
                return $fksValidadas;
            }
            $entidadNuevaContabilizacion = array_merge($entidadContabilizacion, $this->mappearFks());
            $this->repositoryDynamicsCrud->createInfo($this->tablaPmContabilizacion, $entidadNuevaContabilizacion);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], 400);
        }
    }


    public function actualizarPmContabilizacion(String $id, array $entidadContabilizacion)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $contabilizaciondEncontrada = $this->validarContabilizacion($id);
            $fksValidadas = $this->validarFks($entidadContabilizacion);

            if ($contabilizaciondEncontrada || $fksValidadas) {
                return $contabilizaciondEncontrada ?? $fksValidadas;
            }
            $entidadContabilizacion = array_merge($entidadContabilizacion, $this->mappearFks());
            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmContabilizacion, $entidadContabilizacion, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmContabilizacion(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $contabilizacionEncontrado = $this->validarContabilizacion($id);
            if ($contabilizacionEncontrado) {
                return  $contabilizacionEncontrado;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaPmContabilizacion, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerPmContabilizacionPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaPmContabilizacion WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    private function validarFks(array $data)
    {
        $this->idTipoMovimientoDesEncriptado = $this->desencriptarKey(base64_decode($data['pm_tipo_movimiento_id']));
        $this->idCalidadDesEncriptado = $this->desencriptarKey(base64_decode($data['pm_calidad_id']));
        $this->idCuentaDbMaterialDesEncriptado = $this->desencriptarKey(base64_decode($data['cuenta_db_material_id']));
        $this->idCuentaCrMaterialDesEncriptado = $this->desencriptarKey(base64_decode($data['cuenta_cr_material_id']));
        $this->idCuentaDbFleteDesEncriptado = $this->desencriptarKey(base64_decode($data['cuenta_db_flete_id']));
        $this->idCuentaCrFleteDesEncriptado = $this->desencriptarKey(base64_decode($data['cuenta_cr_flete_id']));

        $tipoMovimientoEncontrado = $this->validarTipoMovimiento($this->idTipoMovimientoDesEncriptado);
        $calidadEncontrada = $this->validarCalidad($this->idCalidadDesEncriptado);

        if ($tipoMovimientoEncontrado != null || $calidadEncontrada != null) {
            return $tipoMovimientoEncontrado ?? $calidadEncontrada;
        }
        return null;
    }

    private function mappearFks()
    {
        return [
            "pm_tipo_movimiento_id" => $this->idTipoMovimientoDesEncriptado,
            "pm_calidad_id" => $this->idCalidadDesEncriptado,
            "cuenta_db_material_id" => $this->idCuentaDbMaterialDesEncriptado,
            "cuenta_cr_material_id" => $this->idCuentaCrMaterialDesEncriptado,
            "cuenta_db_flete_id" => $this->idCuentaDbFleteDesEncriptado,
            "cuenta_cr_flete_id" => $this->idCuentaCrFleteDesEncriptado
        ];
    }
    private function validarTipoMovimiento(string $idTipoMovimiento)
    {
        $tipoMovimientoDb = $this->iservicioTipoMovimientos->validarTipoMovimientoId($idTipoMovimiento);
        if (!$tipoMovimientoDb) {
            return response()->json(["Error" => "Tipo movimiento no existente"], 404);
        }
        return null;
    }
    private function validarCalidad(string $idCalidad)
    {
        $calidadDb = $this->iServicioPmCalidades->obtenerPmCalidadPorId($idCalidad);
        if (!$calidadDb) {
            return response()->json(["Error" => "Calidad no existente"], 404);
        }
        return null;
    }
    private function validarContabilizacion(string $idCalidad)
    {
        $contabilizacionDb = $this->obtenerPmContabilizacionPorId($idCalidad);
        if (count($contabilizacionDb) == 0) {
            return response()->json(["Error" => "Contabilizacion no existente"], 404);
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
