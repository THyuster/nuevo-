<?php

namespace App\Utils\Constantes\ModuloMantenimiento;


final class CActas
{

    public function sqlObtenerCentro($ordenId, $tecnicoId, $tipoOrden)
    {
        return
            "SELECT mct.descripcion FROM nomina_centros_trabajos mct 
        INNER JOIN mantenimiento_solicitudes ms ON 
        ms.centro_trabajo_id = mct.id 
        INNER JOIN mantenimiento_ordenes mo ON mo.solicitud_id = ms.id_solicitud 
        INNER JOIN mantenimiento_ordenes_tecnicos mot ON mot.orden_id = mo.id_orden 
        INNER JOIN mantenimiento_tipos_ordenes mto ON mto.codigo = mot.tipo_orden_id 
        WHERE mo.id = $ordenId AND mot.tecnico_id = $tecnicoId AND mto.id= $tipoOrden";
    }


    public function sqlTipoOrdenActa($actaId)
    {
        return "
        SELECT  mto.id,   mto.descripcion   
        FROM mantenimiento_asig_actas mAsigAct
        LEFT JOIN mantenimiento_tipos_ordenes mto ON 
        mAsigAct.tipo_orden_id = mto.id
        WHERE mAsigAct.id = " . $actaId;
    }
    public function sqlValidarTecnicoPertenecienteAlaActa($tecnicoId, $tipoOrdenId, $ordenId)
    {



        return "SELECT  mo.id idOrden, mot.tipo_orden_id idTipoOrden FROM mantenimiento_ordenes mo 
        LEFT JOIN mantenimiento_ordenes_tecnicos mot ON
        mot.orden_id = mo.id_orden 
        LEFT JOIN mantenimiento_asig_actas mAa ON
        mAa.orden_id = mo.id_orden
        WHERE mot.tecnico_id = $tecnicoId  AND mAa.tipo_orden_id = $tipoOrdenId AND mo.id_orden = '$ordenId'";
    }

    public function sqlTecnicoPertenecienteALaOrden($tecnicoId, $tipoOrdenId)
    {
        return "SELECT mot.tecnico_id FROM mantenimiento_ordenes_tecnicos  mot
            WHERE mot.tecnico_id=$tecnicoId AND mot.tipo_orden_id = $tipoOrdenId";
    }
    public function sqlactaAsignadaAlTecnico($ordenId, $idTipoOrden, $tecnicoId)
    {
        return "SELECT * FROM mantenimiento_asig_actas maa 
        LEFT JOIN mantenimiento_ordenes mo on maa.orden_id = mo.id_orden 
        LEFT JOIN mantenimiento_ordenes_tecnicos mot on mo.id_orden  = mot.orden_id 
        LEFT JOIN mantenimiento_tipos_ordenes mto on mot.tipo_orden_id = mto.codigo 
        WHERE mo.id = $ordenId and mto.codigo = $idTipoOrden and mot.tecnico_id =$tecnicoId";
    }

    public function sqlActas()
    {
        // en silicon no se creo la vista porque no tiene un campo en ms
        return  "SELECT * FROM actas_view actas_view ";
    }
    public function sqlActaAsignadasAlTecnico($idTecnico)
    {

        return  $this->sqlActas() . " WHERE actas_view.tecnicoOrden= $idTecnico";
    }

    public function sqlObtenerVehiculoOEquipo($ordenId, $tecnicoId, $tipoOrden)
    {
        return
            "SELECT 
        CASE WHEN afe.id <> '' THEN afe.codigo WHEN lv.placa <> '' THEN lv.placa END codigo , 
        CASE WHEN afe.id <> '' THEN afe.serial_interno WHEN lv.serial_motor <> '' THEN lv.placa END serialx, 
        CASE WHEN afe.id <> '' THEN afe.modelo WHEN lv.id <> '' THEN lv.modelo END marca 
        FROM mantenimiento_solicitudes ms 
        LEFT JOIN mantenimiento_ordenes mo ON mo.solicitud_id = ms.id_solicitud 
        LEFT JOIN mantenimiento_ordenes_tecnicos mot ON mot.orden_id = mo.id_orden 
        LEFT JOIN mantenimiento_tipos_ordenes mto ON mto.codigo = mot.tipo_orden_id 
        LEFT JOIN activos_fijos_equipos afe ON ms.equipo_id = afe.id 
        LEFT JOIN logistica_vehiculos lv ON ms.vehiculo_id = lv.placa 
        WHERE mo.id = $ordenId AND mot.tecnico_id = $tecnicoId AND mto.id = $tipoOrden";
    }
    public function sqlBuscarTecnico($tecnicoId)
    {
        return "SELECT * FROM 	mantenimiento_tecnicos WHERE user_id = " . "$tecnicoId";
    }

    public function sqlBuscarAsignacionActa($idActa)
    {
        return "SELECT * FROM mantenimiento_asig_actas WHERE id = $idActa";
    }

    public function sqlActualizarActaDeDiagnostico($id, $insertActaDiagnostico)
    {
        $consultaSet = '';
        foreach ($insertActaDiagnostico as $atributo => $valor) {
            $consultaSet .= (is_string($valor)) ? "`$atributo`= '$valor', " : "`$atributo`= '$valor', ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return  "UPDATE  mantenimiento_actas_diag SET $consultaSet  WHERE acta_id= $id";
    }

    public function sqlTecnicoAsociadoAlaOrden($ordenId)
    {
        return "SELECT   users.id, users.name
            FROM   users users 
            LEFT JOIN mantenimiento_ordenes_tecnicos mot ON mot.tecnico_id = users.id
            LEFT JOIN mantenimiento_ordenes mo ON mo.id_orden = mot.orden_id
            WHERE mo.id_orden= '$ordenId'";
    }

    public function sqlVerificarSiExisteItem($actaId, $idItemDiagnostico)
    {
        return   "SELECT * FROM mantenimiento_actas_diag 
                    WHERE item_diagnostico_id = $idItemDiagnostico
                    AND acta_id= $actaId";
    }
    public function sqlObtenerTecnicosAlaActa($idOrden, $tipoOrden)
    {
        return  "SELECT mo.id_orden, u.id, u.name FROM mantenimiento_ordenes mo 
                LEFT JOIN mantenimiento_ordenes_tecnicos mot 
                ON mo.id_orden = mot.orden_id
                LEFT JOIN users u on u.id = mot.tecnico_id 
                WHERE id_orden ='$idOrden' and mot.tipo_orden_id ='$tipoOrden'
            ";
    }
}

//No borrar, preguntar a Diego primero
//    SELECT 
//             ma.id AS id,
//             ma.asig_acta_id AS asig_acta_id,
//             ma.tecnico_id AS tecnico_id,
//             ma.fecha AS fecha,
//             ma.observacion AS observacion,
//             ma.tipo_mantenimiento AS tipo_mantenimiento,
//             ma.horometro AS horometro,
//             ma.kilometraje AS kilometraje,
//             ma.ruta_imagen AS ruta_imagen,
//             mhe.fecha_fin AS fecha_fin,
//             mhe.fecha_inicio AS fecha_inicio,
//             mhe.horas_extras AS horas_extras,
//             mhe.tecnico_id AS tecnicoHorasExtras,
//             mhe.id AS idHorasExtras,
//             mi.articulo_id AS idArticuloMantInsumos,
//             mi.cantidad AS cantidadMantInsumos,
//             mi.fecha AS fechaMantInsumos,
//             mi.valor_unidad AS valorMantInsumos,
//             mi.id AS idMantInsumos,
//             mi.clasificacion_articulo AS clasificacion_articulo,
//             ia.descripcion AS descripcionInventarioArticulos,
//             ia.codigo AS codigoInventarioArticulos,
//             ia.id AS idInventarioArticulos,
//             ma.id AS actaId,
//             ms.fecha_solicitud AS fechaInicialSolicitud,
//             ms.id AS idSolicitud,
//             ms.fecha_finalizacion AS fechaFinalSolicitud,
//             ms.equipo_id AS equipoId,
//             ms.vehiculo_id AS vehiculoId,
//             nct.descripcion AS centroTrabajo,
//             x.asignacionActa AS asignacionActa,
//             x.fechaCreacionOrden AS fechaCreacionOrden,
//             x.ordenId AS ordenId,
//             x.solicitud_id AS solicitud_id,
//             x.tipo AS tipo,
//             x.tecnicoOrden AS tecnicoOrden,
//             x.codigoOrden AS codigoOrden
//         FROM (
//             SELECT
//                 maa.id AS asignacionActa,
//                 mo.fecha_creacion AS fechaCreacionOrden,
//                 mo.id_orden AS ordenId,
//                 mo.solicitud_id AS solicitud_id,
//                 mto.descripcion AS tipo,
//                 mot.tecnico_id AS tecnicoOrden,
//                 mto.codigo AS codigoOrden   
//                 FROM db_clientes_mla.mantenimiento_asig_actas maa
//                 JOIN db_clientes_mla.mantenimiento_ordenes mo ON maa.orden_id = mo.id_orden
//                 JOIN db_clientes_mla.mantenimiento_tipos_ordenes mto ON maa.tipo_orden_id = mto.codigo
//                 JOIN db_clientes_mla.mantenimiento_ordenes_tecnicos mot ON mo.id_orden = mot.orden_id
//                 JOIN db_clientes_mla.mantenimiento_tecnicos mt ON mot.tecnico_id = mt.user_id
//                 JOIN db_clientes_mla.mantenimiento_tipos_ordenes mto2 ON mot.tipo_orden_id = mto2.codigo
//                 WHERE mto.codigo = mto2.codigo
//                 ORDER BY 1
//         ) x
//         LEFT JOIN db_clientes_mla.mantenimiento_solicitudes ms ON ms.id_solicitud = x.solicitud_id
//         LEFT JOIN db_clientes_mla.nomina_centros_trabajos nct ON nct.id = ms.centro_trabajo_id
//         LEFT JOIN db_clientes_mla.mantenimiento_actas ma ON ma.asig_acta_id = x.asignacionActa
//         LEFT JOIN db_clientes_mla.mantenimiento_actas_diag mad ON mad.acta_id = ma.id
//         LEFT JOIN db_clientes_mla.mantenimiento_items_diagnostico mid2 ON mid2.id = mad.item_diagnostico_id
//         LEFT JOIN db_clientes_mla.mantenimiento_insumos mi ON mi.acta_id = ma.id
//         LEFT JOIN db_clientes_mla.inventarios_articulos2 ia ON ia.id = mi.articulo_id
//         LEFT JOIN db_clientes_mla.mantenimiento_horas_extras mhe ON mhe.acta_id = ma.id