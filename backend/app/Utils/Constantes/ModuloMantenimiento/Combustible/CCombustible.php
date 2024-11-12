<?php

namespace App\Utils\Constantes\ModuloMantenimiento\Combustible;

use App\Utils\FilterValidation;

class CCombustible
{

    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectAll(): string
    {
        return "SELECT mantenimiento_combustibles.*, mantenimiento_estaciones_servicio.razon_social AS proveedor_nombre FROM mantenimiento_combustibles INNER JOIN mantenimiento_estaciones_servicio on mantenimiento_combustibles.proveedor = mantenimiento_estaciones_servicio.id  ";
    }

    public function sqlSelectId($id): string
    {
        return "SELECT mantenimiento_combustibles.*, mantenimiento_estaciones_servicio.razon_social AS proveedor_nombre FROM mantenimiento_combustibles INNER JOIN mantenimiento_estaciones_servicio on mantenimiento_combustibles.proveedor = mantenimiento_estaciones_servicio.id WHERE mantenimiento_combustibles.id = '$id'";
    }
    public function sqlSelectById($id): string
    {
        return "SELECT * FROM mantenimiento_combustibles WHERE id = '$id'";
    }

    public function sqlInsert($entidadTiposSolicitudes): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor !== null) {
                $consultaCampos .= "`$atributo`, ";
                // $valor = FilterValidation::FilterCampos($valor);
                // $valor = FilterValidation::getCamposDt($valor);
                $consultaValues .= "'$valor',";
            }
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO mantenimiento_combustibles ($consultaCampos) VALUES ($consultaValues)";
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
        return "UPDATE mantenimiento_combustibles SET $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM mantenimiento_combustibles WHERE `id` = '$id'";
    }
}
