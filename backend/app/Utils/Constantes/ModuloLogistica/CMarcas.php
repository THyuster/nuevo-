<?php

namespace App\Utils\Constantes\ModuloLogistica;

final class CMarcas
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlAll()
    {
        return "SELECT * FROM logistica_marcas";
    }
    public function sqlById($id)
    {
        return "SELECT id FROM  logistica_marcas  WHERE  id =$id ";
    }
    public function sqlbuscarCodigoPorId($descripcion, $id)
    {
        return "SELECT id FROM  logistica_marcas  WHERE descripcion = '$descripcion' AND id !=$id ";
    }
    public function sqlDescripcion($descripcion)
    {
        return "SELECT id FROM  logistica_marcas  WHERE descripcion = '$descripcion'";
    }

    public function sqlInsert($EntidadTrailer)
    {

        $consultaCampos = '';
        $consultaValues = '';
        foreach ($EntidadTrailer as $atributo => $valor) {
            if ($valor != null) {
                $consultaCampos .= "`$atributo`, ";
                $consultaValues .= "UPPER('$valor'), ";
            }
        }
        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO logistica_marcas ($consultaCampos) VALUES ($consultaValues)";
    }

    public function sqlUpdate($id, $EntidadArticulo)
    {
        $consultaSet = '';
        foreach ($EntidadArticulo as $atributo => $valor) {
            if ($valor != null) {
                $consultaSet .= "`$atributo`= UPPER('$valor'), ";
            }
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE logistica_marcas SET $consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id)
    {
        return "DELETE FROM logistica_marcas WHERE `id` = $id";
    }

}