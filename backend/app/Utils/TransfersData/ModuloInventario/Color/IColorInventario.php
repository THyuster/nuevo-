<?php
namespace App\Utils\TransfersData\ModuloInventario\Color;
interface IColorInventario 
{


    public function getColorInventario();
    public function addColorInventario($inventarios);
    public function removeColorInventario($id);
    public function updateColorInventario($id, $inventarios);
    public function updateEstadoColorInventario($id);

}