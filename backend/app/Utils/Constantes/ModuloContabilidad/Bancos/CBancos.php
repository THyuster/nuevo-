<?php
namespace App\Utils\Constantes\ModuloContabilidad\Bancos;

class CBancos {

    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM contabilidad_bancos WHERE codigo = '$codigo'";
    }

    public function sqlSelectAll(): string
    {
        return  "SELECT * FROM contabilidad_bancos";
    }
    public function sqlSelectById($id): string
    {
        return "SELECT * FROM contabilidad_bancos WHERE id = '$id'";
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

        return "INSERT INTO contabilidad_bancos ($consultaCampos) VALUES ($consultaValues)";
    }

    public function sqlUpdate($id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= ('$valor'), ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE contabilidad_bancos SET $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM contabilidad_bancos WHERE `id` = '$id'";
    }

    public function sqlUpdateEstado($id, $estado)
    {
        return "UPDATE contabilidad_bancos
        SET `estado`='$estado'
        WHERE `id` = '$id'";
    }

}