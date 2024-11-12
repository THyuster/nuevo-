<?php
namespace App\Utils\Constantes\ModuloMantenimiento\Mediciones;

class CMediciones
{

    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM mantenimiento_relacion_hkc WHERE id = '$codigo'";
    }

    


    public function sqlSelectAll(): string
    {
        return "SELECT  mantenimiento_relacion_hkc.* FROM mantenimiento_relacion_hkc";
    }
   
    public function sqlSelectById($id): string
    {
        return "SELECT hkc.*, lv.placa as placa_vehiculo, ae.codigo as codigo_equipo 
        FROM mantenimiento_relacion_hkc hkc LEFT JOIN activos_fijos_equipos ae ON 
        ae.id = hkc.equipo_id LEFT JOIN logistica_vehiculos lv ON lv.id = hkc.vehiculo_id 
        WHERE lv.placa IS NOT NULL OR ae.codigo IS NOT NULL AND hkc.id = '$id' ";
    }

    public function sqlInsert($entidadTiposSolicitudes): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor !== null) {
                $consultaCampos .= "`$atributo`, ";
                $consultaValues .= (is_string($valor)) ? "UPPER('$valor')," : "'$valor',";
            }
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO mantenimiento_relacion_hkc (`fecha_creacion`,$consultaCampos) VALUES ('$this->date',$consultaValues)";
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
        return "UPDATE mantenimiento_relacion_hkc SET `fecha_ultima_actualizacion` = '$this->date', $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM mantenimiento_relacion_hkc WHERE id = '$id'";
    }
}