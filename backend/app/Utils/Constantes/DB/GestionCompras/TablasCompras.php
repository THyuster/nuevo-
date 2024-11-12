<?php

namespace App\Utils\Constantes\DB\GestionCompras;


use App\Utils\Constantes\DB\Tesoreria\TablasTesoreria;

class TablasCompras extends TablasTesoreria
{
    private const TABLA_CLIENTES_GC_PRESUPUESTO = "gc_presupuestos";
    private const TABLA_CLIENTES_GC_PRESUPUESTO_DETALLE = "gc_presupuestos_detalle";

    private const TABLA_CLIENTES_GC_PRESUPUESTO_DETALLE_RELACION = "gc_presupuestos_detalle_relacion";
    private const TABLA_CLIENTES_GC_ORDENES = "gc_ordenes";
    private const TABLA_ERP_GC_ORDENES = "erp_gc_tipos_ordenes";
    private const TABLA_CLIENTES_GC_ORDENES_DETALLE = "gc_ordenes_detalle";

    private const TABLA_CLIENTES_GC_ORDENES_DETALLE_RELACION = "gc_ordenes_detalle_rel";
    private const TABLA_CLIENTES_GC_REQUISICIONES = "gc_requisiciones";
    private const TABLA_CLIENTES_GC_REQUISICIONES_DETALLE = "gc_requisiciones_detalle";

    private const TABLA_CLIENTES_GC_REQUISICIONES_DETALLE_RELACION = "gc_requisiciones_detalle_rel";


    public static function getTablaClienteGcPresupuesto()
    {
        return self::TABLA_CLIENTES_GC_PRESUPUESTO;
    }
    public static function getTablaClienteGcDetallePresupuesto()
    {
        return self::TABLA_CLIENTES_GC_PRESUPUESTO_DETALLE;
    }
    public static function getTablaClienteGcDetallePresupuestoRelacion()
    {
        return self::TABLA_CLIENTES_GC_PRESUPUESTO_DETALLE_RELACION;
    }
    public static function getTablaClienteGcOrdenes()
    {
        return self::TABLA_CLIENTES_GC_ORDENES;
    }
    public static function getTablaErpTipoOrdenes()
    {
        return self::TABLA_ERP_GC_ORDENES;
    }
    public static function getTablaClienteGcDetalleOrdenes()
    {
        return self::TABLA_CLIENTES_GC_ORDENES_DETALLE;
    }
    public static function getTablaClienteGcDetalleOrdenesRelacion()
    {
        return self::TABLA_CLIENTES_GC_ORDENES_DETALLE_RELACION;
    }
    public static function getTablaClienteGcRequisiciones()
    {
        return self::TABLA_CLIENTES_GC_REQUISICIONES;
    }
    public static function getTablaClienteGcDetalleRequisiciones()
    {
        return self::TABLA_CLIENTES_GC_REQUISICIONES_DETALLE;
    }
    public static function getTablaClienteGcDetalleRequisicionesRelacion()
    {
        return self::TABLA_CLIENTES_GC_REQUISICIONES_DETALLE_RELACION;
    }
}