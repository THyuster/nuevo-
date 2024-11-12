<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\moduloContabilidad\Third;

class ServicioPmCodigos  implements IServicioPmCodigos
{
    private String $tablaPmCodigos, $tablaContabilidadTerceros, $tablaUsers, $tablaTipoCodigo, $tablaPatio, $idZonaDesEncriptado;
    private String  $idTipoCodigoDesEncriptado, $idPmPatioDesEncriptado, $idTipoRegaliaDesEncriptado, $idTerceroDesEncriptado, $idComercializadorDesEncriptado;
    private String $tablaTipoRegalia, $tablaZona;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioPatios $servicioPatios;

    private IServicioPmTipoRegalia $servicioPmTipoRegalia;

    private IServicioTipoCodigo $servicioTipoCodigo;

    private IServicioPmZonas $servicioPmZonas;
    private Third  $third;




    public function __construct(
        RepositoryDynamicsCrud $repositoryDynamicsCrud,
        IServicioPatios $servicioPatios,
        IServicioPmTipoRegalia $servicioPmTipoRegalia,
        IServicioTipoCodigo $servicioTipoCodigo,
        IServicioPmZonas $servicioPmZonas
    ) {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaPmCodigos = tablas::getTablaClientePmCodigos();
        $this->tablaContabilidadTerceros = tablas::getTablaClienteContabilidadTerceros();
        $this->tablaUsers = tablas::getTablaAppUser();
        $this->tablaTipoCodigo = tablas::getTablaClientePmTiposCodigos();
        $this->tablaPatio = tablas::getTablaClientePmPatios();
        $this->tablaTipoRegalia = tablas::getTablaClientePmTipoRegalia();
        $this->tablaZona = tablas::getTablaClientePmZona();
        $this->servicioPatios = $servicioPatios;
        $this->servicioPmTipoRegalia = $servicioPmTipoRegalia;
        $this->servicioTipoCodigo = $servicioTipoCodigo;
        $this->servicioPmZonas = $servicioPmZonas;

        $this->third = new Third();
    }

    public function obtenerPmCodigos()
    {
        try {
            $sql = "
            SELECT 
             pmc.*,
            ct.id idTercero,
            ct.nombre_completo nombreTercero,
            pmtc.id idTipoCodigo,
            pmtc.codigo codigoTipoCodigo,
            pmtc.descripcion descripcionTipoCodigo,
            pmp.id idPatio,
            pmp.codigo codigoPatio,
            pmp.descripcion descripcionPatio,
            pmtr.id idTipoRegalia,
            pmtr.codigo codigoTipoRegalia,
            pmtr.descripcion descripcionTipoRegalia,
            pmz.id idZona,
            pmz.codigo codigoZona,
            pmz.descripcion descripcionZona,
            u.id IdUser,
            u.name nombreComercializador

            FROM $this->tablaPmCodigos pmc
            LEFT JOIN $this->tablaContabilidadTerceros ct ON ct.id = pmc.contabilidad_tercero_id 
             LEFT JOIN $this->tablaUsers u  ON u.id = pmc.comercializador_user_id
            LEFT JOIN $this->tablaTipoCodigo pmtc ON pmtc.id = pmc.pm_tipo_codigo_id 
            LEFT JOIN $this->tablaPatio pmp ON pmp.id = pmc.pm_patio_id 
            LEFT JOIN $this->tablaTipoRegalia pmtr ON pmtr.id = pmc.pm_tipo_regalia_id 
            LEFT JOIN $this->tablaZona pmz ON pmz.id = pmc.pm_zona_id
            ";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaPmCalidades = array_map(function ($codigo) {
                $codigo->id = base64_encode($this->encriptarKey($codigo->id));
                $codigo->tercero =  (object)[
                    "id" => ($codigo->idTercero),
                    "nombre" => $codigo->nombreTercero
                ];
                $codigo->tipoCodigo =  (object)[
                    "id" => base64_encode($this->encriptarKey($codigo->idTipoCodigo)),
                    "codigo" => $codigo->codigoTipoCodigo,
                    "descripcion" => $codigo->descripcionTipoCodigo
                ];
                $codigo->patio =  (object)[
                    "id" => base64_encode($this->encriptarKey($codigo->idPatio)),
                    "codigo" => $codigo->codigoPatio,
                    "descripcion" => $codigo->descripcionPatio
                ];
                $codigo->tipoRegalia =  (object)[
                    "id" => base64_encode($this->encriptarKey($codigo->idTipoRegalia)),
                    "codigo" => $codigo->codigoTipoRegalia,
                    "descripcion" => $codigo->descripcionTipoRegalia
                ];
                $codigo->zona =  (object)[
                    "id" => base64_encode($this->encriptarKey($codigo->idZona)),
                    "codigo" => $codigo->codigoZona,
                    "descripcion" => $codigo->descripcionZona
                ];

                $codigo->comercializador =  (object)[
                    "id" => $codigo->IdUser,
                    "nombre" => $codigo->nombreComercializador
                ];
                unset(
                    $codigo->idTercero,
                    $codigo->nombreTercero,
                    $codigo->idTipoCodigo,
                    $codigo->codigoTipoCodigo,
                    $codigo->descripcionTipoCodigo,
                    $codigo->idPatio,
                    $codigo->codigoPatio,
                    $codigo->descripcionPatio,
                    $codigo->idTipoRegalia,
                    $codigo->codigoTipoRegalia,
                    $codigo->descripcionTipoRegalia,
                    $codigo->idZona,
                    $codigo->codigoZona,
                    $codigo->descripcionZona,
                    $codigo->contabilidad_tercero_id,
                    $codigo->comercializador_user_id,
                    $codigo->pm_tipo_codigo_id,
                    $codigo->pm_patio_id,
                    $codigo->pm_tipo_regalia_id,
                    $codigo->pm_zona_id,
                    $codigo->IdUser,
                    $codigo->nombreComercializador,

                );
                return $codigo;
            }, $resultadosDb);
            return response()->json(["datos" => $respuestaPmCalidades], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function crearPmCodigo(array $entidadPmCodigo)
    {
        try {
            $respuesta = $this->validarFks($entidadPmCodigo);
            if ($respuesta) {
                return $respuesta;
            }
            $nuevaEntiedad = array_merge($entidadPmCodigo,  $this->mapearFks());
            $this->repositoryDynamicsCrud->createInfo($this->tablaPmCodigos, $nuevaEntiedad);
            return response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function actualizarPmCodigo(String $id, array $entidadPmCodigo)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $respuesta = $this->validarFks($entidadPmCodigo);
            $codigoEncontrado = $this->validarCodigoPorId($id);
            if ($respuesta || $codigoEncontrado) {
                return $respuesta ?? $codigoEncontrado;
            }
            $nuevaEntidadCodigo = array_merge($entidadPmCodigo,  $this->mapearFks());
            $this->repositoryDynamicsCrud->updateInfo($this->tablaPmCodigos, $nuevaEntidadCodigo, $id);
            return response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function eliminarPmCodigo(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $codigoEncontrado = $this->validarCodigoPorId($id);
            if ($codigoEncontrado) {
                return  $codigoEncontrado;
            }

            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaPmCodigos, $id);
            return response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    private function validarFks($data)
    {
        $this->idTipoCodigoDesEncriptado = $this->desEncriptarKey(base64_decode($data['pm_tipo_codigo_id']));
        $this->idPmPatioDesEncriptado = $this->desEncriptarKey(base64_decode($data['pm_patio_id']));
        $this->idTipoRegaliaDesEncriptado = $this->desEncriptarKey(base64_decode($data['pm_tipo_regalia_id']));
        $this->idZonaDesEncriptado = $this->desEncriptarKey(base64_decode($data['pm_zona_id']));
        $this->idTerceroDesEncriptado = $data['contabilidad_tercero_id'];
        $this->idComercializadorDesEncriptado = $data['comercializador_user_id'];


        $codigoEncontrado = $this->servicioTipoCodigo->validarTipoCodigoPorId($this->idTipoCodigoDesEncriptado);
        $patioEncontrado = $this->servicioPatios->validarPatioPorId($this->idPmPatioDesEncriptado);
        $tipoRegaliaEncontrada = $this->servicioPmTipoRegalia->validarTipoRegalia($this->idTipoRegaliaDesEncriptado);
        $terceroEncontrado = $this->third->validarTerceroPorId($this->idTerceroDesEncriptado);
        $zonaEncontrado = $this->servicioPmZonas->validarZona($this->idZonaDesEncriptado);

        if ($patioEncontrado || $tipoRegaliaEncontrada || $codigoEncontrado || $terceroEncontrado || $zonaEncontrado) {
            return $patioEncontrado ?? $tipoRegaliaEncontrada ?? $codigoEncontrado ?? $terceroEncontrado ?? $zonaEncontrado;
        }
    }

    private function mapearFks()
    {
        return [
            "pm_patio_id" => $this->idPmPatioDesEncriptado,
            "pm_tipo_regalia_id" => $this->idTipoRegaliaDesEncriptado,
            "pm_tipo_codigo_id" => $this->idTipoCodigoDesEncriptado,
            "contabilidad_tercero_id" => $this->idTerceroDesEncriptado,
            "comercializador_user_id" => $this->idComercializadorDesEncriptado,
            "pm_zona_id" => $this->idZonaDesEncriptado
        ];
    }
    public function obtenerPmCodigoPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaPmCodigos WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }


    public function validarCodigoPorId(string $idCalidad)
    {
        $calidadDb = $this->obtenerPmCodigoPorId($idCalidad);
        if (count($calidadDb) == 0) {
            return response()->json(["Error" => "Codigo no existente"], 404);
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
