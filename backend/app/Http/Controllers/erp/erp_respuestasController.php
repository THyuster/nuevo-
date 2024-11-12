<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use App\Utils\Repository\RepositoryDynamicsCrud;



class erp_respuestasController extends Controller
{

    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
    }
    public function show()
    {
        $sql = "SELECT id, tipo_respuesta AS descripcion FROM erp_mant_respuestas";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
}
