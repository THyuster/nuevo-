<?php
namespace App\Utils\TransfersData\ModuloInventario\Linea;

use App\Utils\Constantes\ModuloContabilidad\Centros\Ccentros;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;


interface ILineaInventario 
{


    public function getLineaInventario();
    public function addLineaInventario($inventarios);
    public function removeLineaInventario($id);
    public function updateLineaInventario($id, $inventarios);
    public function updateEstadoLineaInventario($id);

}