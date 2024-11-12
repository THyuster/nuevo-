<?php

namespace App\Utils\Constantes\ProduccionMinera;

use App\Utils\Constantes\DB\tablas;

class SqlTiposMovimientos
{

    private String $tablaTipoMovimiento, $tablaTipoMovimientoRelacion;
    public function __construct()
    {

        $this->tablaTipoMovimiento = tablas::getTablaClientePmTiposMovimientos();
        $this->tablaTipoMovimientoRelacion = tablas::getTablaClientePmTiposMovimientosRelacion();
    }


    public function obtenerTipoMovimientos()
    {
        return
            "SELECT 
        ptm.id idMovimiento, 
        ptm.descripcion descripcionMovimiento, 
        ptm.codigo codigoMovimiento, 
        ptm.estado estadoMovimiento, 
        ptmr.id idMovimientoRelacion, 
        ptc.id idTipoCodigoSalida, 
        ptc.codigo codigoTipoCodigoSalida, 
        ptc.descripcion descripcionTipoCodigoSalida, 
        ptc2.id idTipoCodigoLlegada, 
        ptc2.codigo codigoTipoCodigoLlegada, 
        ptc2.descripcion descripcionTipoCodigoLlegada, 
        ptp.id idTipoPatioSalida, 
        ptp.descripcion descripcionTipoPatioSalida, 
        ptp2.id idTipoPatioLlegada, 
        ptp2.descripcion descripcionTipoPatioLlegada 
        FROM pm_tipo_movimiento ptm 
        LEFT JOIN pm_tipo_movimiento_relacion ptmr ON ptmr.tipo_movimiento_id = ptm.id 
        LEFT JOIN pm_tipo_codigos ptc ON ptc.id = ptmr.tipo_codigo_salida_id 
        LEFT JOIN pm_tipo_codigos ptc2 ON ptc2.id = ptmr.tipo_codigo_llegada_id 
        LEFT JOIN pm_tipos_patios ptp ON ptp.id = ptmr.tipo_patio_salida_id 
        LEFT JOIN pm_tipos_patios ptp2 ON ptp2.id = ptmr.tipo_patio_llegada_id";
    }
    public function obtenerTipoMovimientosRelacion($tipoCodigoSalidaId, $tipoCodigoLlegadaId,  $tipoPatioLlegadaId, $tipoPatioSalidaId)
    {
        return  "SELECT * FROM $this->tablaTipoMovimientoRelacion WHERE
         tipo_codigo_llegada_id = '$tipoCodigoLlegadaId' AND 
         tipo_codigo_salida_id= '$tipoCodigoSalidaId' AND 
         tipo_patio_salida_id ='$tipoPatioSalidaId' AND 
         tipo_patio_llegada_id = '$tipoPatioLlegadaId'";
    }

    public function eliminarTipoMovimientoRelacion($id)
    {
        return "DELETE  $this->tablaTipoMovimientoRelacion, $this->tablaTipoMovimiento
                 FROM $this->tablaTipoMovimientoRelacion
                 LEFT JOIN $this->tablaTipoMovimiento ON $this->tablaTipoMovimientoRelacion.tipo_movimiento_id = $this->tablaTipoMovimiento.id
                WHERE $this->tablaTipoMovimientoRelacion.tipo_movimiento_id = '$id'";
    }
    public function obtenerTipoMovimiento($id)
    {
        return "SELECT * FROM $this->tablaTipoMovimiento WHERE id = '$id'";
    }
    public function obtenerTipoMovimientoConRelacion($id)
    {
        return "SELECT *, ptmr.id idRelacion  FROM $this->tablaTipoMovimiento ptm
                LEFT JOIN $this->tablaTipoMovimientoRelacion ptmr
                ON ptm.id = ptmr.tipo_movimiento_id
                WHERE ptm.id = '$id'";
    }
}
