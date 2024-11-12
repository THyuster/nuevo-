<?php
namespace App\Utils\Constantes\ModuloInventario\Departamentos;

class CDepartamentos {

    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM inventarios_departamento WHERE codigo = '$codigo'";
    }

    public function sqlSelectAll(): string
    {
        return  "SELECT * FROM inventarios_departamento";
    }
    public function sqlSelectById($id): string
    {
        return "SELECT * FROM inventarios_departamento WHERE id = '$id'";
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

        return "INSERT INTO inventarios_departamento ($consultaCampos) VALUES ($consultaValues)";
    }

    public function sqlUpdate($id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= ('$valor'), ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE inventarios_departamento SET $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM inventarios_departamento WHERE `id` = '$id'";
    }

    public function sqlUpdateEstado($id, $estado)
    {
        return "UPDATE inventarios_departamento
        SET `estado`='$estado'
        WHERE `id` = '$id'";
    }

}