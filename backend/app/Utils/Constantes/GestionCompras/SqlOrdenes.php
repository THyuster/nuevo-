<?php

namespace App\Utils\Constantes\GestionCompras;

use App\Utils\Constantes\DB\tablas;

final class SqlOrdenes
{

    private string $tablaOrdenes, $tablaOrdenesDetalles, $tablaDetalleRelacion;

    public function __construct()
    {
        $this->tablaOrdenes = tablas::getTablaClienteGcOrdenes();
        $this->tablaOrdenesDetalles = tablas::getTablaClienteGcDetalleOrdenes();
        $this->tablaDetalleRelacion = tablas::getTablaClienteGcDetalleOrdenesRelacion();
    }

    public function sqlObtenerOrdenes()
    {
        return "SELECT
                gco.id,
                gco.id_tipo_orden,
                gco.id_usuario usuario,
                gco.id_presupuesto idPresupuesto,
                gco.estado estadoOrden,
                gco.descripcion descripcionOrden,
                gco.comentarios comentarioOrden,
                gcod.id idDetale,
                gcod.id_articulo idArticulo,
                CONCAT(ia.codigo, ' - ', ia.descripcion) descripcionArticulo,
                gcod.id_activo_fijo idEquipo,
                CONCAT(afe.codigo, ' - ', afe.descripcion)descripcionEquipo,
                gcod.id_centro_trabajo idCentroTrabajo,
                gcod.cantidad cantidad,
                gcod.precio_unitario,
                gcod.total,
                gcod.fecha_entrega_estimada,
                gcod.ruta_imagen
            FROM
                gc_ordenes gco
            LEFT JOIN gc_ordenes_detalle_rel gcodr ON
                gcodr.id_orden = gco.id
            LEFT JOIN gc_ordenes_detalle gcod ON
                gcod.id = gcodr.id_detalle
            LEFT JOIN inventarios_articulos2 ia ON ia.id = gcod.id_articulo
            LEFT JOIN activos_fijos_equipos afe ON afe.id = gcod.id_activo_fijo
            LEFT JOIN mla_erp_data.erp_gc_tipos_ordenes egcto ON egcto.id = gco.id_tipo_orden
            LEFT JOIN mla_erp_data.users u ON u.id= gco.id_usuario
        ";
    }
    public function sqlObtenerDetallesOrdenesPorId($id)
    {
        return "SELECT     gcod.id idDetalle FROM $this->tablaOrdenes gco
        LEFT JOIN $this->tablaDetalleRelacion gcodr ON  gcodr.id_orden = gco.id
        LEFT JOIN $this->tablaOrdenesDetalles gcod ON    gcod.id = gcodr.id_detalle 
        WHERE gco.id = '$id'
        ";
    }

    public function sqlEliminarOrdenesConDetallesPorId($idOrden)
    {
        return "DELETE
            gc_ordenes_detalle_rel,
            gc_ordenes_detalle
        FROM
            gc_ordenes_detalle_rel
        LEFT JOIN gc_ordenes_detalle ON gc_ordenes_detalle.id = gc_ordenes_detalle_rel.id_detalle
        LEFT JOIN gc_ordenes ON gc_ordenes.id = gc_ordenes_detalle_rel.id_orden
        WHERE
            gc_ordenes_detalle_rel.id_detalle IN($idOrden)";
    }

    public function sqlEliminarOrdenesConDetallesPorIdDetalle($idDetalle)
    {
        return "DELETE
            gc_ordenes_detalle_rel,
            gc_ordenes_detalle,
            gc_ordenes
        FROM
            gc_ordenes_detalle_rel
        LEFT JOIN gc_ordenes_detalle ON gc_ordenes_detalle_rel.id_detalle = gc_ordenes_detalle.id
        LEFT JOIN gc_ordenes ON gc_ordenes.id = gc_ordenes_detalle_rel.id_orden
        WHERE gc_ordenes.id = '$idDetalle'";
    }

}