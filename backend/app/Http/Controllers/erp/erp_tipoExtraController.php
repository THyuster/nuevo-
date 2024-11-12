<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;

use App\Utils\Repository\RepositoryDynamicsCrud;

class erp_tipoExtraController extends Controller
{
    protected $repositoryDynamicsCrud;
    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
    }

    public function show()
    {
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_tipos_horas_extras");
    }
}
