<?php
namespace App\Utils\Constantes\ModuloMantenimiento\Horometros;

class CHorometros
{

    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectAll(): string
    {
        return "SELECT * FROM mantenimiento_horometros";
    }
    public function sqlSelectById($id): string
    {
        return "SELECT * FROM mantenimiento_horometros WHERE id = '$id'";
    }

    public function sqlInsert($entidadTiposSolicitudes): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaCampos .= "`$atributo`, ";
            $consultaValues .= "'$valor',";
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO mantenimiento_horometros ($consultaCampos) VALUES ($consultaValues)";
    }

    public function sqlUpdate($id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            // $valor = $filter
            // $consultaSet.= "`$atributo` =";
            $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= '$valor', ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE mantenimiento_horometros SET $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM mantenimiento_horometros WHERE `id` = '$id'";
    }

}