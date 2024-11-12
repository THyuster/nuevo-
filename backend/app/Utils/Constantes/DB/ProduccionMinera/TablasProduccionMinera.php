<?php

namespace App\Utils\Constantes\DB\ProduccionMinera;

use App\Utils\Constantes\DB\GestionCompras\TablasCompras;



class TablasProduccionMinera extends TablasCompras
{
    private const TABLA_CLIENTES_PM_TIPOS_PATIOS = "pm_tipos_patios";
    private const TABLA_CLIENTES_PM_TIPOS_CODIGOS = "pm_tipo_codigos";
    private const TABLA_CLIENTES_PM_TIPOS_MOVIMIENTO = "pm_tipo_movimiento";
    private const TABLA_CLIENTES_PM_TIPOS_MOVIMIENTO_RELACION = "pm_tipo_movimiento_relacion";
    private const TABLA_CLIENTES_PM_PATIOS = "pm_patios";
    private const TABLA_CLIENTES_PM_bodegas = "pm_bodegas";
    private const TABLA_CLIENTES_PM_TIPO_USO = "pm_tipo_uso";
    private const TABLA_CLIENTES_PM_TARIFAS_TRASLADOS = "pm_tarifas_traslados";
    private const TABLA_CLIENTES_PM_PRODUCTOS = "pm_productos";
    private const TABLA_CLIENTES_PM_CALIDADES = "pm_calidades";
    private const TABLA_CLIENTES_PM_TIPO_REGALIA = "pm_tipo_regalia";
    private const TABLA_CLIENTES_PM_TARIFA_REGALIA = "pm_tarifa_regalia";
    private const TABLA_CLIENTES_PM_GRANULOMETRIAS = "pm_granulometrias";
    private const TABLA_CLIENTES_PM_TECHOS_CALIDAD = "pm_techos_calidad";
    private const TABLA_CLIENTES_PM_CONTABILIZACION = "pm_contabilizacion";
    private const TABLA_CLIENTES_PM_ZONA = "pm_zonas";
    private const TABLA_CLIENTES_PM_CODIGOS = "pm_codigos";
    private const TABLA_CLIENTES_PM_TECHOS_CODIGOS = "pm_techos_codigos";
    private const TABLA_CLIENTES_PM_CUPOS = "pm_cupos";
    private const TABLA_CLIENTES_PM_MAQUILA = "pm_maquila";
    private const TABLA_CLIENTES_PM_RELACION_CODIGO_MAQUILA = "pm_relacion_codigo_maquila";
    public static function getTablaClientePmTiposPatios()
    {
        return self::TABLA_CLIENTES_PM_TIPOS_PATIOS;
    }
    public static function getTablaClientePmTiposCodigos()
    {
        return self::TABLA_CLIENTES_PM_TIPOS_CODIGOS;
    }
    public static function getTablaClientePmTiposMovimientos()
    {
        return self::TABLA_CLIENTES_PM_TIPOS_MOVIMIENTO;
    }
    public static function getTablaClientePmTiposMovimientosRelacion()
    {
        return self::TABLA_CLIENTES_PM_TIPOS_MOVIMIENTO_RELACION;
    }
    public static function getTablaClientePmPatios()
    {
        return self::TABLA_CLIENTES_PM_PATIOS;
    }
    public static function getTablaClientePmBodegas()
    {
        return self::TABLA_CLIENTES_PM_bodegas;
    }
    public static function getTablaClientePmTipoUso()
    {
        return self::TABLA_CLIENTES_PM_TIPO_USO;
    }
    public static function getTablaClientePmTarifasTraslados()
    {
        return self::TABLA_CLIENTES_PM_TARIFAS_TRASLADOS;
    }
    public static function getTablaClientePmProductos()
    {
        return self::TABLA_CLIENTES_PM_PRODUCTOS;
    }
    public static function getTablaClientePmCalidades()
    {
        return self::TABLA_CLIENTES_PM_CALIDADES;
    }
    public static function getTablaClientePmTipoRegalia()
    {
        return self::TABLA_CLIENTES_PM_TIPO_REGALIA;
    }
    public static function getTablaClientePmTarifaRegalia()
    {
        return self::TABLA_CLIENTES_PM_TARIFA_REGALIA;
    }
    public static function getTablaClientePmGranulometrias()
    {
        return self::TABLA_CLIENTES_PM_GRANULOMETRIAS;
    }
    public static function getTablaClientePmTechosCalidad()
    {
        return self::TABLA_CLIENTES_PM_TECHOS_CALIDAD;
    }
    public static function getTablaClientePmContabilizacion()
    {
        return self::TABLA_CLIENTES_PM_CONTABILIZACION;
    }
    public static function getTablaClientePmZona()
    {
        return self::TABLA_CLIENTES_PM_ZONA;
    }
    public static function getTablaClientePmCodigos()
    {
        return self::TABLA_CLIENTES_PM_CODIGOS;
    }
    public static function getTablaClientePmTechosCodigos()
    {
        return self::TABLA_CLIENTES_PM_TECHOS_CODIGOS;
    }
    public static function getTablaClientePmCupos()
    {
        return self::TABLA_CLIENTES_PM_CUPOS;
    }
    public static function getTablaClientePmMaquila()
    {
        return self::TABLA_CLIENTES_PM_MAQUILA;
    }
    public static function getTablaClientePmRelacionCodigoMaquila()
    {
        return self::TABLA_CLIENTES_PM_RELACION_CODIGO_MAQUILA;
    }
}
