<?php
namespace App\Utils\Constantes\ModuloMantenimiento\Ordenes;

use App\Utils\Constantes\DB\tablas;

class COrdenesTecnicos
{

    protected $date;
    private $TablaOrdensTecnicos;
    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->TablaOrdensTecnicos = tablas::getTablaClienteOrdenesTecnicos();
    }

    public function sqlSelectByCode(string $codigo): string
    {
        return "SELECT * FROM $this->TablaOrdensTecnicos WHERE id = '$codigo'";
    }

    public function sqlSelectAll(): string
    {
        return "SELECT * FROM $this->TablaOrdensTecnicos";
    }
    public function sqlSelectById($id): string
    {
        return "SELECT * FROM $this->TablaOrdensTecnicos WHERE id = '$id'";
    }

    public function sqlInsert($entidadTiposSolicitudes): string
    {
        $consultaCampos = '';
        $consultaValues = '';

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor !== null) {
                $consultaCampos .= "`$atributo`, ";
                $consultaValues .=  "'$valor',";
            }
        }

        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO $this->TablaOrdensTecnicos ($consultaCampos) VALUES ($consultaValues)";
    }

    public function sqlUpdate($id, $entidadTiposSolicitudes): string
    {
        $consultaSet = '';
        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor !== null) {
                $consultaSet .= (is_string($valor)) ? "`$atributo`= '$valor', " : "`$atributo`= '$valor', ";
            }
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE $this->TablaOrdensTecnicos SET `fecha_ultima_actualizacion` = '$this->date', $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id): string
    {
        return "DELETE FROM $this->TablaOrdensTecnicos WHERE id = '$id'";
    }
}