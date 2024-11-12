<?php

namespace App\Utils\Constantes\ModuloLogistica;

final class CTrailers
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode($codigo)
    {
        return "SELECT * FROM logistica_trailers WHERE codigo = '$codigo'";
    }
    public function sqlSelectAll()
    {
        return "SELECT id, codigo, descripcion FROM logistica_trailers";
    }

    public function sqlSelectById($id)
    {
        return "SELECT id, codigo, descripcion FROM logistica_trailers WHERE id = '$id'";
    }
    public function sqlInsert($EntidadTrailer)
    {

        $consultaCampos = '';
        $consultaValues = '';
        foreach ($EntidadTrailer as $atributo => $valor) {
            $consultaCampos .= "`$atributo`, ";
            $consultaValues .= "UPPER('$valor'), ";
        }
        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO logistica_trailers (`created_at`, `updated_at`,$consultaCampos) VALUES ('$this->date', '$this->date', $consultaValues)";
    }

    public function sqlUpdate($id, $EntidadArticulo)
    {
        $consultaSet = '';
        foreach ($EntidadArticulo as $atributo => $valor) {
            $consultaSet .= "`$atributo`= UPPER('$valor'), ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE logistica_trailers SET `updated_at`='$this->date',$consultaSet WHERE `id` = '$id'";
    }

    public function sqlDelete($id)
    {
        return "DELETE FROM logistica_trailers WHERE `id` = $id";
    }

}