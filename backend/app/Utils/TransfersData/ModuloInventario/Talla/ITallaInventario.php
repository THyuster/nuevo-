<?php
namespace App\Utils\TransfersData\ModuloInventario\Talla;
interface ITallaInventario 
{


    public function getTallaInventario();
    public function addTallaInventario($inventarios);
    public function removeTallaInventario($id);
    public function updateTallaInventario($id, $inventarios);
    public function updateEstadoTallaInventario($id);

}