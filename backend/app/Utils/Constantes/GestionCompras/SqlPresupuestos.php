<?php

namespace App\Utils\Constantes\GestionCompras;

use App\Utils\Constantes\DB\tablas;

final class SqlPresupuestos
{
    private $tablaPresupuesto;

    public function __construct()
    {
        $this->tablaPresupuesto = tablas::getTablaClienteGcPresupuesto();
    }

    public function obtenerPresupuestoConRelaciones()
    {
        return "SELECT 
                gcp.id idPresupuesto, 
                gcpdr.id idDetalle, 
                gcpdr.*, 
                gcp.*, 
                gcpd.*, 
                u.id idUsuario,
                u.name nombreUsuario, 
                nct.id idCentroTrabajo,
                nct.codigo codigoCentroTrabajo,
                nct.descripcion descripcionCentroTrabajo,
                iga.id idGrupoArticulo,
                iga.codigo codigoGrupoArticulo,
                iga.descripcion descripcionGrupoArticulo,
                afge.id idActivoFijo,
                afge.codigo codigoActivoFijo,
                afge.descripcion descripcionActivoFijo
                FROM gc_presupuestos_detalle_relacion gcpdr
                RIGHT JOIN  gc_presupuestos gcp ON  gcp.id= gcpdr.id_presupuesto
                LEFT JOIN  gc_presupuestos_detalle gcpd  ON gcpd.id= gcpdr.id_detalle
                LEFT JOIN  mla_erp_data.users u ON  u.id = gcp.id_usuario
                LEFT JOIN nomina_centros_trabajos nct ON nct.id = gcpd.id_centro_trabajo
                LEFT JOIN inventarios_grupo_articulos iga ON iga.id = gcpd.id_grupo_articulo
                LEFT JOIN activos_fijos_grupos_equipos afge ON afge.id = gcpd.id_activos_fijos_grupos_equipos
                ORDER BY gcp.id;
                ";
    }

    public function sqlEliminarPresupuestoPorId(string $id)
    {
        return "DELETE gc_presupuestos_detalle_relacion, gc_presupuestos_detalle, gc_presupuestos FROM gc_presupuestos_detalle_relacion
                LEFT JOIN gc_presupuestos_detalle ON gc_presupuestos_detalle.id = gc_presupuestos_detalle_relacion.id_detalle
                LEFT JOIN gc_presupuestos ON gc_presupuestos.id = gc_presupuestos_detalle_relacion.id_presupuesto
                WHERE gc_presupuestos_detalle_relacion.id_presupuesto= '$id'";
    }

    public function ssqlObtenerDetallesRelacionadosAlPresupuesto(string $id)
    {
        return "SELECT gcpd.* FROM gc_presupuestos_detalle_relacion gcpdr LEFT JOIN gc_presupuestos_detalle gcpd ON gcpd.id = gcpdr.id_detalle WHERE gcpdr.id_presupuesto = $id";
    }

    public function sqlEliminarDetalles(string $idsDetalles)
    {
        return "DELETE  gcpdr, gcpd FROM gc_presupuestos_detalle_relacion gcpdr LEFT JOIN gc_presupuestos_detalle gcpd ON gcpd.id = gcpdr.id_detalle
            WHERE gcpdr.id_detalle IN ($idsDetalles)";
    }


    public function validarParejasFksUnicas($idCentroTrabajo, $idArticulo, $idActivoFijo)
    {
        return
            "SELECT 
            gcpd.id,
            iga.id idGrupoArticulo,
            CONCAT(iga.id , ' - ', iga.codigo, ' - ', iga.descripcion) descripcionGrupoArticulo,
            afge.id idGrupoEquipo, 
            CONCAT(afge.id , ' - ', afge.codigo, ' - ', afge.descripcion) descripcionGrupoEquipo,
            CONCAT(  nct.codigo,  ' - ',  nct.descripcion ) centroTrabajo
            FROM gc_presupuestos_detalle gcpd 
            LEFT JOIN inventarios_grupo_articulos iga ON iga.id = gcpd.id_grupo_articulo 
            LEFT JOIN activos_fijos_grupos_equipos afge ON afge.id = gcpd.id_activos_fijos_grupos_equipos 
            LEFT JOIN nomina_centros_trabajos nct ON nct.id =  gcpd.id_centro_trabajo
            WHERE gcpd.id_centro_trabajo = $idCentroTrabajo AND (
                gcpd.id_grupo_articulo IN( $idArticulo) OR 
                gcpd.id_activos_fijos_grupos_equipos IN( $idActivoFijo) 
            )";
    }

    public function sqlObtenerUltimaFechaFin()
    {
        return "SELECT MAX(DATE_ADD(fecha_fin, INTERVAL 1 DAY)) AS nueva_fecha_fin FROM $this->tablaPresupuesto";
    }

    public function sqlObtenerDetallesConRequiciones($idPresupuesto)
    {
        return "SELECT DISTINCT
            gcp.id idPresupuesto,
            -- gcpr.id idRelacion,
            -- gcpd.id idDetalle,
            gcpd.id_grupo_articulo idGrupoArticulo,
            gcpd.costo_unitario costoPresupuesto,
            gcpd.id_activos_fijos_grupos_equipos idGrupoEquipo,
            gcr.id idRequisicion,
            gcrd.id idDetalleRequisicion,
            gcr.descripcion descripcionRequisicion,
            -- gcrdr.id idRelacionRequisicion,
            gcrd.id_articulo idArticulo,
            gcrd.id_activo_fijo_equipo idActivofijo
        FROM
            gc_presupuestos gcp
        LEFT JOIN gc_presupuestos_detalle_relacion gcpr ON
            gcpr.id_presupuesto = gcp.id
        LEFT JOIN gc_presupuestos_detalle gcpd ON
            gcpd.id = gcpr.id_detalle
        LEFT JOIN gc_requisiciones gcr ON
            gcr.id_presupuesto = gcp.id
        LEFT JOIN gc_requisiciones_detalle_rel gcrdr ON
            gcrdr.id_requisicion = gcr.id
        LEFT JOIN gc_requisiciones_detalle gcrd ON
            gcrd.id = gcrdr.id_detalle
        LEFT JOIN inventarios_grupo_articulos iga ON
            iga.id = gcpd.id_grupo_articulo
        LEFT JOIN activos_fijos_grupos_equipos afge ON
            afge.id = gcpd.id_activos_fijos_grupos_equipos
        LEFT JOIN inventarios_articulos2 ia ON
            (
                ia.id = gcrd.id_articulo
            )
        LEFT JOIN activos_fijos_equipos afe ON
            (
                afe.id = gcrd.id_activo_fijo_equipo
            )
        WHERE
            gcp.id ='$idPresupuesto' 
            and (
                ( gcpd.id_grupo_articulo is not null and gcrd.id_articulo is not null )
                OR
                ( gcpd.id_activos_fijos_grupos_equipos is not null and gcrd.id_activo_fijo_equipo is not null )        
                )
        order by 4;";
    }


    public function sqlObtenerGruposAsociadosARequisiciones($idPresupuesto, $idGrupoArticulos, $idGrupoEquipos)
    {
        $sql = "
            SELECT
                  gcpd.id_grupo_articulo idGrupoArticulos,
                    gcpd.id_activos_fijos_grupos_equipos idGrupoEquipos
            FROM
                gc_presupuestos_detalle gcpd
            LEFT JOIN gc_presupuestos_detalle_relacion gcpdr ON
                gcpdr.id_detalle = gcpd.id
            LEFT JOIN gc_requisiciones gcr ON
                gcr.id_presupuesto = gcpdr.id_presupuesto
            LEFT JOIN gc_requisiciones_detalle_rel gcdr ON
                gcdr.id_requisicion = gcr.id
            LEFT JOIN gc_requisiciones_detalle gcrd ON
                (gcrd.id = gcdr.id_detalle) AND(
                    gcrd.id_grupo_articulo = gcpd.id_grupo_articulo
                )
            WHERE
                gcpdr.id_presupuesto = '$idPresupuesto' AND
                (
                gcpd.id_grupo_articulo IN($idGrupoArticulos)
                ) OR(
                    gcpd.id_activos_fijos_grupos_equipos IN($idGrupoEquipos)
            )
        ";
        return $sql;
    }

}
