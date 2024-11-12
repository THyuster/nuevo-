<?php
namespace App\Utils\Constantes\ModuloMantenimiento\Ordenes;

use App\Utils\Constantes\DB\tablas;

class COrdenes
{

    protected $date;
    private $tablaCMantenimientoOrdenes;
    private $tablaCMantenimientoAsigActas;
    private $tablaCMantenimientoSolicitudes;
    private $tablaCTiposSolicitudes;
    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->tablaCMantenimientoAsigActas = tablas::getTablaClienteMantenimientoAsigActas();
        $this->tablaCMantenimientoOrdenes = tablas::getTablaClienteMantenimientoOrdenes();
        $this->tablaCMantenimientoSolicitudes = tablas::getTablaClienteMantenimientoSolicitudes();
        $this->tablaCTiposSolicitudes = tablas::getTablaAppTiposSolicitudes();
    }

    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM $this->tablaCMantenimientoOrdenes WHERE id = '$codigo'";
    }

    public function sqlGetBySolicitudId($id_solicitud)
    {
        return "SELECT * FROM $this->tablaCMantenimientoOrdenes WHERE solicitud_id = '$id_solicitud'";
    }

    public function sqlSelectAll(): string
    {
        return "SELECT  * FROM $this->tablaCMantenimientoOrdenes";
    }

    public function sqlAllOrdenesBySolicitudes()
    {
        return "SELECT s.id_solicitud, s.observacion, ts.descripcion, mo.fecha_creacion, mo.fecha_modificacion, mo.id_orden,
        CASE
            WHEN mo.solicitud_id IS NOT NULL THEN 'Orden Creada'
            ELSE 'Orden por Crear'
        END AS estado_orden
        FROM $this->tablaCMantenimientoSolicitudes s INNER JOIN $this->tablaCTiposSolicitudes ts ON s.tipo_solicitud_id = ts.id
        LEFT JOIN $this->tablaCMantenimientoOrdenes mo ON s.id_solicitud = mo.solicitud_id COLLATE utf8mb4_unicode_ci";
    }

    public function sqlSelectById($id): string
    {
        return "SELECT * FROM $this->tablaCMantenimientoOrdenes WHERE id = '$id'";
    }

    public function sqlInsert($entidadTiposSolicitudes): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor !== null) {
                $consultaCampos .= "`$atributo`, ";
                $consultaValues .= (is_string($valor)) ? "'$valor'," : "'$valor',";
            }
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO $this->tablaCMantenimientoOrdenes (`fecha_creacion`, `fecha_modificacion`,$consultaCampos) VALUES ('$this->date','$this->date',$consultaValues)";
    }

    public function sqlUpdate($id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor !== null) {
                $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= '$valor', ";
            }
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE $this->tablaCMantenimientoOrdenes SET `fecha_modificacion` = '$this->date',$consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM $this->tablaCMantenimientoOrdenes WHERE id_orden = '$id'";
    }
    public function sqlDeleteAsignacionXacta($id): string
    {
        return "DELETE FROM $this->tablaCMantenimientoAsigActas WHERE orden_id = '$id'";
    }

    public function sqlAsignacionActaInMantenimientoActas($entidadAsignacion)
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadAsignacion as $atributo => $valor) {
            if ($valor !== null) {
                $consultaCampos .= "`$atributo`, ";
                $consultaValues .= (is_string($valor)) ? "'$valor'," : "'$valor',";
            }
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');
        return "INSERT INTO $this->tablaCMantenimientoAsigActas ($consultaCampos) VALUES ($consultaValues)";
    }

}