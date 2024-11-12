<?php
namespace App\Utils\TransfersData\ModuloInventario\Departamentos;

use App\Utils\Constantes\ModuloContabilidad\Centros\Ccentros;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;


interface IDepartamentosInventario 
{


    public function getDepartamentosInventario();
    public function addDepartamentosInventario($inventarios);
    public function removeDepartamentosInventario($id);
    public function updateDepartamentosInventario($id, $inventarios);
    public function updateEstadoDepartamentosInventario($id);

}