<?php

namespace App\Http\Controllers\modulo_gestion_calidad;

use App\Http\Controllers\Controller;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Http\Request;

class TipoSolicitudController extends Controller
{
    protected $repositoryDynamicsCrud;
    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
    }
    public function show()
    {
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM tipos_solicitud");
    }
}
