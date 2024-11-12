<?php
namespace App\Utils\Constantes\ModuloMantenimiento\Estaciones;

use App\Utils\FilterValidation;

class CEstaciones
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectAll(): string
    {
        return "SELECT cm.descripcion, mantenimiento_estaciones_servicio.* FROM mantenimiento_estaciones_servicio INNER JOIN  contabilidad_municipios cm on mantenimiento_estaciones_servicio.municipio_id =  cm.id  ";
    }
    public function sqlSelectById($id): string
    {
        return "SELECT * FROM mantenimiento_estaciones_servicio WHERE id = '$id'";
    }
    public function sqlSelectByCode($codigo): string
    {
        return "SELECT * FROM mantenimiento_estaciones_servicio WHERE codigo = '$codigo'";
    }

    public function sqlInsert($entidadTiposSolicitudes): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor !== null) {
                $consultaCampos .= "`$atributo`, ";
                $consultaValues .= "'$valor',";
            }
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO mantenimiento_estaciones_servicio (`estado`, $consultaCampos) VALUES (1,$consultaValues)";
    }

    public function sqlUpdate($id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor !== null) {
                $valor = FilterValidation::FilterCampos($valor);
                $valor = FilterValidation::getCamposDt($valor);
                $consultaSet .= "`$atributo`= $valor";
            }
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE mantenimiento_estaciones_servicio SET `fecha_ultima_actualizacion` = '$this->date', $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM mantenimiento_estaciones_servicio WHERE `id` = '$id'";
    }
    public function sqlEstado($id, $estado): string
    {
        return "UPDATE mantenimiento_estaciones_servicio SET `estado` = '$estado' WHERE `id` = '$id'";
    }

}