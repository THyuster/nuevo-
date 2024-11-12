<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoUso;
use Illuminate\Http\Request;

class pm_tipoUsoController extends Controller
{

    private IServicioTipoUso $iServicioTipoUso;
    public function __construct(IServicioTipoUso  $iServicioTipoUso)
    {
        $this->iServicioTipoUso = $iServicioTipoUso;
    }
    public function obtener()
    {
        return $this->iServicioTipoUso->obtenerTiposUso();
    }
}
