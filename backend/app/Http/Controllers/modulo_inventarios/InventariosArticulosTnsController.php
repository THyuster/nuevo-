<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\DataManagerApi;
use App\Utils\Repository\RepositoryDynamicsCrud;

class InventariosArticulosTnsController extends Controller
{
    protected $repository;
    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
    }
    public function materialesTnsAArticulos()
    {
        try {
            $dataManager = new DataManagerApi();
            $dns = "erp_tns";

            $sqlQuery = "SELECT COUNT(*)  FROM demovi";
            $datos = $dataManager->ObtenerDatos($dns, $sqlQuery);
            return $datos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
