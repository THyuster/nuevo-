<?php

namespace App\Utils\Constantes\DB\Mantenimiento;

use App\Utils\Constantes\DB\Contabilidad\TablasContabilidad;

class TablasMantenimiento extends TablasContabilidad
{
    private const TABLA_CLIENTES_MANTENIMIENTO_ORDENES_TECNICOS = "mantenimiento_ordenes_tecnicos";
    private const TABLA_CLIENTES_MANTENIMIENTO_SOLICITUDES = "mantenimiento_solicitudes";
    private const TABLA_CLIENTES_MANTENIMIENTO_ASIGNACION_ACTAS = "mantenimiento_asig_actas";
    private const TABLA_CLIENTES_MANTENIMIENTO_ORDENES = "mantenimiento_ordenes";
    private const TABLA_CLIENTES_MANTENIMIENTO_ACTAS = "mantenimiento_actas";
    private const TABLA_CLIENTES_MANTENIMIENTO_ACTAS_DIAGNOSTICO = "mantenimiento_actas_diag";
    private const TABLA_CLIENTES_MANTENIMIENTO_RELACION_HOROMETROS_KILOMETROS_COMBUSTIBLE = "mantenimiento_relacion_hkc";
    private const TABLA_CLIENTES_MANTENIMIENTO_KILOMETROS = "mantenimiento_kilometros";
    private const TABLA_CLIENTES_MANTENIMIENTO_HOROMETROS = "mantenimiento_horometros";
    private const TABLA_CLIENTES_MANTENIMIENTO_COMBUSTIBLE = "mantenimiento_combustibles";
    private const TABLA_CLIENTES_MANTENIMIENTO_ESTACIONES_SERVICIO = "mantenimiento_estaciones_servicio";
    private const TABLA_CLIENTES_MANTENIMIENTO_TIPO_SOLICITUDES = "mantenimiento_tipos_ordenes";
    private const TABLA_CLIENTES_ITEMS_DIAGNOSTICO = "mantenimiento_items_diagnostico";
    private const TABLA_CLIENTES_ENTREGAS_DIRECTAS = "mantenimiento_entregas_directas";
    private const TABLA_CLIENTES_RELACION_ENTREGA_ARTICULO = "mantenimiento_relacion_articulos_entregas_directas";
    private const TABLA_ERP_MANTENIMIENTO_RESPUESTA = "erp_mant_respuestas";
    private const TABLA_CLIENTE_MANTENIMIENTO_RELACION_HOMOLOGACIONES_ARTICULOS = "mantenimiento_relacion_homologaciones_articulos";
    private const TABLA_CLIENTE_MANTENIMIENTO_HORAS_EXTRAS = "mantenimiento_horas_extras";
    private const TABLA_CLIENTE_MANTENIMIENTO_INSUMOS = "mantenimiento_insumos";


    public static function getTablaClienteOrdenesTecnicos()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_ORDENES_TECNICOS;
    }
    public static function getTablaClienteMantenimientoSolicitudes()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_SOLICITUDES;
    }
    public static function getTablaClienteMantenimientoAsigActas()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_ASIGNACION_ACTAS;
    }
    public static function getTablaClienteMantenimientoOrdenes()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_ORDENES;
    }

    public static function getTablaClienteMantenimientoActas()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_ACTAS;
    }

    public static function getTablaClienteMantenimientoActasDiagnostico()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_ACTAS_DIAGNOSTICO;
    }
    public static function getTablaClienteMantenimientoRelacionHKC()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_RELACION_HOROMETROS_KILOMETROS_COMBUSTIBLE;
    }
    public static function getTablaClienteMantenimientoKilometros()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_KILOMETROS;
    }
    public static function getTablaClienteMantenimientoHorometros()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_HOROMETROS;
    }
    public static function getTablaClienteMantenimientoCombustible()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_COMBUSTIBLE;
    }
    public static function getTablaClienteMantenimientoEstacionesServicio()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_ESTACIONES_SERVICIO;
    }

    public static function getTablaClienteMantenimientoTipoSolicitud()
    {
        return self::TABLA_CLIENTES_MANTENIMIENTO_TIPO_SOLICITUDES;
    }
    public static function getTablaClientemantenimientoItemsDiagnostico()
    {
        return self::TABLA_CLIENTES_ITEMS_DIAGNOSTICO;
    }
    public static function getTablaClientemantenimientoEntregaDirecta()
    {
        return self::TABLA_CLIENTES_ENTREGAS_DIRECTAS;
    }
    public static function getTablaClientemantenimientoRelacionArticuloEntregaDirecta()
    {
        return self::TABLA_CLIENTES_RELACION_ENTREGA_ARTICULO;
    }
    public static function getTablaErpMantenimientoRespuesta()
    {
        return self::TABLA_ERP_MANTENIMIENTO_RESPUESTA;
    }
    public static function getTablaClienteMantenimientoRelacionHomoArticulos()
    {
        return self::TABLA_CLIENTE_MANTENIMIENTO_RELACION_HOMOLOGACIONES_ARTICULOS;
    }
    public static function getTablaClienteMantenimientoHorasExtras()
    {
        return self::TABLA_CLIENTE_MANTENIMIENTO_HORAS_EXTRAS;
    }
    public static function getTablaClienteMantenimientoInsumos()
    {
        return self::TABLA_CLIENTE_MANTENIMIENTO_INSUMOS;
    }
}
