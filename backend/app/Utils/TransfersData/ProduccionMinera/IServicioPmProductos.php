<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use Illuminate\Http\Request;

interface IServicioPmProductos
{
    public function obtenerProduto();
    public function obteneProdutoPorId(String $id);
    public function crearProduto(array $entidadProducto);
    public function actualizarProduto(String $id, array $entidadProducto);
    public function eliminarProduto(String $id);
}
