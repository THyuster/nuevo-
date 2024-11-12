<?php
namespace App\Utils\Constantes\ModuloMantenimiento\Kilometros;

class CKilometros
{

    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    /* public function sqlSelectByCode(string $codigo): string
     {
         return "SELECT * FROM mantenimiento_kilometros WHERE id = '$codigo'";
     }*/

    public function sqlSelectAll(): string
    {
        return "SELECT * FROM mantenimiento_kilometros";
    }
    public function sqlSelectById($id): string
    {
        return "SELECT * FROM mantenimiento_kilometros WHERE id = '$id'";
    }

    public function sqlInsert($entidadTiposSolicitudes): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaCampos .= "`$atributo`, ";
            $consultaValues .= (is_string($valor)) ? "UPPER('$valor')," : "'$valor',";
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO mantenimiento_kilometros ($consultaCampos) VALUES ($consultaValues)";
    }

    public function sqlUpdate($id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= '$valor', ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE mantenimiento_kilometros SET $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM mantenimiento_kilometros WHERE `id` = '$id'";
    }

    /*   public function sqlUpdateEstado($id, $estado)
       {
           return "UPDATE mantenimiento_kilometros
           SET `estado`='$estado'
           WHERE `id` = '$id'";
       }*/

}