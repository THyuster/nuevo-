<?php

namespace App\Utils\Constantes\ModuloMantenimiento;


class CTiposSolicitudes
{
    protected $date;

    function sqlFuncion($tabla): string
    {
        return "SELECT * FROM `$tabla`";
    }

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM mantenimiento_tipos_solicitudes WHERE codigo = '$codigo'";
    }

    public function sqlSelectAll(): string
    {
        return " SELECT * FROM mantenimiento_tipos_solicitudes";
    }
    public function sqlSelectById(int $id): string
    {
        return "SELECT * FROM mantenimiento_tipos_solicitudes WHERE id = '$id'";
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

        return "INSERT INTO mantenimiento_tipos_solicitudes (`created_at`, `updated_at`,$consultaCampos) VALUES ('$this->date', '$this->date', $consultaValues)";
    }

    public function sqlUpdate(int $id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            $consultaSet .= (is_string($valor)) ? "`$atributo`= UPPER('$valor'), " : "`$atributo`= ('$valor'), ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE mantenimiento_tipos_solicitudes SET `updated_at`='$this->date',$consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete(int $id): string
    {
        return "DELETE FROM mantenimiento_tipos_solicitudes WHERE `id` = '$id'";
    }
}
