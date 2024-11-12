<?php

namespace App\Utils\Constantes\ModuloMantenimiento;

use App\Utils\Constantes\DB\tablas;

final class CItemsDiagnostico
{
    protected $date;
    private $tablaCMantenimientoItemsDiagnostico;
    private $tablaCMantenimientoActasDiag;
    private $tablaCMantenimientoTiposOrdenes, $tablaCMantenimientoAsigActas;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->tablaCMantenimientoItemsDiagnostico = tablas::getTablaClientemantenimientoItemsDiagnostico();
        $this->tablaCMantenimientoActasDiag = tablas::getTablaClienteMantenimientoActasDiagnostico();
        $this->tablaCMantenimientoTiposOrdenes = tablas::getTablaClienteMantenimientoTipoSolicitud();
        $this->tablaCMantenimientoAsigActas = tablas::getTablaClienteMantenimientoAsigActas();
    }
    public function sqlObtenerTodosLosItemsConRespuesta()
    {
        return "SELECT
        mid.tipo_clasificacion,
        mid.id,
        mid.estado,
        mid.descripcion,
        mto.descripcion tipoOrden,
        mad.respuesta respuestaItems,
        mad.observacion observacionItems,
        mto.id AS tipo_orden_id,
        respuestas.id AS tipo_clasificacion_id
    FROM
        mantenimiento_items_diagnostico MID
    INNER JOIN mantenimiento_tipos_ordenes mto ON
        mid.tipo_orden_id = mto.codigo_usuario
    INNER JOIN mla_erp_data.erp_mant_respuestas respuestas ON 
        respuestas.tipo_respuesta = mid.tipo_clasificacion
    INNER JOIN mantenimiento_actas_diag mad ON
        mad.item_diagnostico_id = mid.id";
    }

    public function sqlObtenerTodosLosItems()
    {
        return "SELECT DISTINCT mid.*, 
        mto.descripcion tipoOrden,
        mto.id AS tipo_orden_id,
        respuestas.id AS tipo_clasificacion_id
        FROM $this->tablaCMantenimientoItemsDiagnostico  mid 
        INNER JOIN mla_erp_data.erp_mant_respuestas respuestas 
        ON respuestas.tipo_respuesta = mid.tipo_clasificacion
        LEFT JOIN $this->tablaCMantenimientoTiposOrdenes mto 
        ON mid.tipo_orden_id = mto.codigo";
    }

    public function sqlItemsTipoOrden(int $idAsigActa, $actaId)
    {
        return
            "
                SELECT 
                    DISTINCT mid.*, mto.descripcion tipoOrden, mad.respuesta respuestaItems, mad.observacion observacionItems
                    FROM mantenimiento_items_diagnostico MID
                    LEFT JOIN mantenimiento_actas_diag MAD ON MID.id = MAD.item_diagnostico_id
                    AND MAD.acta_id = $actaId
                    LEFT JOIN mantenimiento_tipos_ordenes mto on MID.tipo_orden_id = mto.codigo 
                       WHERE mid.tipo_orden_id in (
                    SELECT maa.tipo_orden_id FROM mantenimiento_asig_actas maa WHERE maa.id= $idAsigActa
                );
            ";
        // return
        //     "SELECT DISTINCT mid.*, mto.descripcion tipoOrden, mad.respuesta respuestaItems, mad.observacion observacionItems 
        //         FROM mantenimiento_items_diagnostico mid 
        //         LEFT JOIN mantenimiento_tipos_ordenes mto on mid.tipo_orden_id = mto.codigo 
        //         LEFT JOIN mantenimiento_actas_diag mad on mad.item_diagnostico_id = mid.id 
        //         WHERE mid.tipo_orden_id in (
        //             SELECT maa.tipo_orden_id FROM mantenimiento_asig_actas maa WHERE maa.id= $idAsigActa
        //         );
        //     ";


    }
}