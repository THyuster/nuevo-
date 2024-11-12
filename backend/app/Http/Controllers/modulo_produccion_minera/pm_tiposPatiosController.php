<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoPatios;

class pm_tiposPatiosController extends Controller
{
    private IServicioTipoPatios $iServicioTipoPatio;
    public function __construct(IServicioTipoPatios  $iServicioTipoPatio)
    {
        $this->iServicioTipoPatio = $iServicioTipoPatio;
    }
    public function obtener()
    {
        return $this->iServicioTipoPatio->obtenerTiposPatios();
    }
}
