<?php

namespace App\Http\Controllers\modulo_logistica;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloLogistica\CCombustiblesLogistica;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloLogistica\ServicesBlindajes;

class logistica_combustibleController extends Controller
{
    protected $repository, $servicesBlindajes;
    
    protected CCombustiblesLogistica $_cCombustible;

    public function __construct(CCombustiblesLogistica $cCombustiblesLogistica)
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->servicesBlindajes = new ServicesBlindajes;
        $this->_cCombustible = $cCombustiblesLogistica;

    }

    public function show()
    {
        return $this->repository->sqlFunction($this->_cCombustible->sqlGetCombustibles());
    }


}
