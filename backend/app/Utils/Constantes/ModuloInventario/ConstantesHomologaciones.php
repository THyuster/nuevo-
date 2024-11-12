<?php

namespace App\Utils\Constantes\ModuloInventario;

use App\Utils\Constantes\DB\tablas;

class ConstantesHomologaciones
{

    private  $nameDataBase, $tablaMantHomolArticulos, $tablaInvArticulos;

    protected $sqlHomologacion;

    public function __construct()
    {

        $this->nameDataBase = "mantenimiento_homologaciones";
        $this->tablaMantHomolArticulos = tablas::getTablaClienteMantenimientoRelacionHomoArticulos();
        $this->tablaInvArticulos = tablas::getTablaErpInventarioArticulos();
    }


    public function obtenerHomologacion($id)
    {
        return "SELECT * FROM $this->nameDataBase ih WHERE ih.id = '$id'";
    }

    public function obtenerCodigoDiferenteId($id, $codigo)
    {
        return "SELECT * FROM $this->nameDataBase ih WHERE ih.codigo= '$codigo' AND ih.id != '$id'";
    }
    public function obtenerCodigo($codigo)
    {
        return "SELECT * FROM $this->nameDataBase ih WHERE  ih.codigo = '$codigo'";
    }
    public function obtenerArticulosHomologados($idsArticulosString)
    {
        return  "
        SELECT ia.codigo ,ia.descripcion FROM $this->tablaMantHomolArticulos mrha 
        LEFT JOIN $this->tablaInvArticulos ia ON ia.id = mrha.id_articulo
        WHERE mrha.id_articulo IN ($idsArticulosString)";
    }
    public function obtenerArticulosHomologadosConId($idsArticulosString, $id)
    {
        return  "
        SELECT ia.codigo ,ia.descripcion FROM $this->tablaMantHomolArticulos mrha 
        LEFT JOIN $this->tablaInvArticulos ia ON ia.id = mrha.id_articulo
        WHERE mrha.id_articulo IN ($idsArticulosString) AND  mrha.id_homologacion != $id";
    }
}
