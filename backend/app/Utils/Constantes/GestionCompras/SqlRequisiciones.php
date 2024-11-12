<?php

namespace App\Utils\Constantes\GestionCompras;

use App\Utils\Constantes\DB\tablas;

final class SqlRequisiciones
{
    private $tablaPresupuestoDetalle, $tablaPresupuesto, $tablaPresupuestoDetalleRelacion;

    public function __construct()
    {
        $this->tablaPresupuestoDetalle = tablas::getTablaClienteGcDetallePresupuesto();
        $this->tablaPresupuesto = tablas::getTablaClienteGcPresupuesto();
        $this->tablaPresupuestoDetalleRelacion = tablas::getTablaClienteGcDetallePresupuestoRelacion();

    }

    public function obtenerRequisiciones()
    {
        return "SELECT
            gcr.id idRequisicion,
            gcr.id_presupuesto idPresupuesto,
            gcr.descripcion descripcionRequisicion,
            u.name usuario,
            nct.id idCentroTrabajo,
            CONCAT( nct.codigo, ' - ',  nct.descripcion ) AS nominaCentroTrabajo,
            gcrd.id idDetalle,
            ia.id idArticulo,
            CONCAT(ia.codigo, ' - ', ia.descripcion) AS descripcionArticulo,
            afe.id idEquipoFijo,
            CONCAT(afe.codigo, ' - ', afe.descripcion) AS descripcionEquipoFijo,
            gcr.estado_presupuesto_cerrado estadoPresupuestoCerrado,
            gcr.urgencia urgenciaRequisicion,
            gcr.estado estadoRequisicion,
            gcr.comentarios comentariosRequisicion,
            gcr.proyecto proyectoRequisicion,
            gcr.fecha_creacion fechaCreacionRequisicion,
            gcrd.id_grupo_articulo,
            gcrd.id_grupo_equipo,
            gcrd.cantidad,
            gcrd.cantidad_autorizada cantidadAutorizada,
            gcrd.cantidad_comprada cantidadComprada,
            gcrd.costo_estimado costoEstimado,
            gcrd.total_estimado totalEstimado,
            gcrd.comentarios,
            gcrd.ruta_imagen imagenUrl,
            gcp.nombre_presupuesto nombrePresupuesto
            
        FROM
            gc_requisiciones gcr
        LEFT JOIN gc_requisiciones_detalle_rel gcrdr ON
            gcrdr.id_requisicion = gcr.id
        LEFT JOIN gc_requisiciones_detalle gcrd ON
            gcrd.id = gcrdr.id_detalle
        LEFT JOIN inventarios_articulos2 ia ON
            ia.id = gcrd.id_articulo
        LEFT JOIN activos_fijos_equipos afe ON
            afe.id = gcrd.id_activo_fijo_equipo
        LEFT JOIN nomina_centros_trabajos nct ON
            nct.id = gcr.id_centro_trabajo
        LEFT JOIN mla_erp_data.users u ON u.id = gcr.id_usuario
        LEFT JOIN gc_presupuestos gcp ON gcp.id = gcr.id_presupuesto 
        "
        ;
    }

    public function obtenerDetallesPresupuestos($idCentriTrabajoExistente, $fechaPresupuesto)
    {
        return "SELECT 
        gcpd.id_grupo_articulo, 
        CONCAT(ia.codigo, ' - ', ia.descripcion) as articuloDescripcion,
        ia.id id_articulo,
        af.id id_activo_fijo,
        gcpd.id_activos_fijos_grupos_equipos,
        CONCAT(af.id, ' - ', af.descripcion) as activoFijoDescripcion
        FROM $this->tablaPresupuestoDetalle gcpd
        LEFT JOIN inventarios_articulos2 ia ON ia.grupo_articulo_id  = gcpd.id_grupo_articulo
        LEFT JOIN activos_fijos_equipos af ON af.grupo_equipo_id = gcpd.id_activos_fijos_grupos_equipos
        LEFT JOIN gc_presupuestos_detalle_relacion gcpdr ON gcpdr.id_detalle = gcpd.id
        WHERE id_centro_trabajo = '$idCentriTrabajoExistente' AND gcpdr.id_presupuesto = '$fechaPresupuesto'";
    }
    public function obtenerPresupuestoDeFechaDeRequisicion($fechaCreacionRequisicion)
    {
        return "SELECT gcp.id, gcp.valor_tope FROM $this->tablaPresupuesto gcp 
        LEFT JOIN $this->tablaPresupuestoDetalleRelacion gcpdr ON gcp.id = gcpdr.id_presupuesto
        LEFT JOIN $this->tablaPresupuestoDetalle gcpd ON gcpd.id = gcpdr.id_detalle
        WHERE gcp.fecha_inicio <= '$fechaCreacionRequisicion' AND gcp.fecha_fin >= '$fechaCreacionRequisicion'";
    }
    public function obtenerValoresPresupuesto($idPresupuesto, $articulos, $activosFijos): string
    {
        return " SELECT
            gcp.id idPresupuesto,
            gcpd.costo_unitario costoPresupuestado,
            ia.id idArticulo,
            CONCAT(iga.codigo , ' - ', iga.descripcion ) as grupoArticulo,
            CONCAT(ia.id, ' - ', ia.descripcion) as articulo,
            af.id idActivoFijo,
            CONCAT(afge.id, ' - ', afge.descripcion) as grupoEquipo,
            CONCAT(af.id, ' - ', af.descripcion) as equipo
            FROM $this->tablaPresupuesto gcp
            LEFT JOIN $this->tablaPresupuestoDetalleRelacion gcpdr ON gcp.id = gcpdr.id_presupuesto
            LEFT JOIN $this->tablaPresupuestoDetalle gcpd ON gcpd.id = gcpdr.id_detalle
            LEFT JOIN inventarios_articulos2 ia ON ia.grupo_articulo_id = gcpd.id_grupo_articulo
            LEFT JOIN activos_fijos_equipos af ON af.grupo_equipo_id = gcpd.id_activos_fijos_grupos_equipos
            LEFT JOIN inventarios_grupo_articulos iga ON iga.id = gcpd.id_grupo_articulo
            LEFT JOIN activos_fijos_grupos_equipos afge ON afge.id = gcpd.id_activos_fijos_grupos_equipos
            WHERE
                gcp.id = '$idPresupuesto' AND (
                    ia.id IN ($articulos) OR af.id IN ($activosFijos)
                );
        ";
    }

    public function sqlEliminarRequisicion($idPresupuesto)
    {
        return "DELETE
            gc_requisiciones_detalle_rel,
            gc_requisiciones_detalle,  gc_requisiciones
        FROM
            gc_requisiciones_detalle_rel
        LEFT JOIN gc_requisiciones_detalle ON gc_requisiciones_detalle_rel.id_detalle = gc_requisiciones_detalle.id
        LEFT JOIN gc_requisiciones ON gc_requisiciones.id = gc_requisiciones_detalle_rel.id_requisicion
        WHERE
            gc_requisiciones_detalle_rel.id_requisicion  = '$idPresupuesto'";

    }
    public function sqlObtenerDetallesRequisicones($idRequisicion)
    {
        return "SELECT gc_requisiciones_detalle.* 
        FROM gc_requisiciones_detalle_rel 
        LEFT JOIN gc_requisiciones_detalle ON gc_requisiciones_detalle_rel.id_detalle = gc_requisiciones_detalle.id 
        where gc_requisiciones_detalle_rel.id_requisicion = '$idRequisicion'";
    }

    public function sqEliminarDetalles($idDetalle)
    {
        return "DELETE
                gc_requisiciones_detalle_rel, gc_requisiciones_detalle
                FROM
                    gc_requisiciones_detalle_rel
                LEFT JOIN gc_requisiciones_detalle ON gc_requisiciones_detalle_rel.id_detalle = gc_requisiciones_detalle.id
                WHERE
                    gc_requisiciones_detalle_rel.id_detalle IN ($idDetalle)";
    }

    public function sqlObtenerArticulosConGrupos()
    {
        return "SELECT 
        ia.id idArticulo,
        CONCAT(ia.codigo, ' - ', ia.descripcion) as descripcionArticulo,
        iga.id idGrupoArticulo,
        CONCAT(iga.codigo, ' - ', iga.descripcion) as descripcionGrupoArticulo
        FROM inventarios_articulos2 ia
        LEFT JOIN inventarios_grupo_articulos iga ON iga.id = ia.grupo_articulo_id";
    }

    public function sqlObtenerEquiposConGrupos()
    {
        return "SELECT 
        af.id idActivoFijo,
        CONCAT(af.codigo, ' - ', af.descripcion) as descripcionActivoFijo,
        afge.id idGrupoEquipo,
        CONCAT(afge.codigo, ' - ', afge.descripcion) as descripcionGrupoEquipo
        FROM activos_fijos_equipos af
        LEFT JOIN activos_fijos_grupos_equipos afge ON afge.id = af.grupo_equipo_id";
    }
}
