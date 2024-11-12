<?php
namespace App\Http\Controllers\modulo_contabilidad\PlanUnicoCuentas;
use App\Http\Controllers\Controller;
use App\Utils\TransfersData\moduloContabilidad\PlanUnicoCuentas\IServicioCuentaAuxiliares;

class CuentasAuxiliaresController extends Controller{

    private IServicioCuentaAuxiliares $iServicioCuentaAuxiliares;
    public function __construct(IServicioCuentaAuxiliares $iServicioCuentaAuxiliares) {
        $this->iServicioCuentaAuxiliares = $iServicioCuentaAuxiliares;
    }

    public function obtener() {
        return $this->iServicioCuentaAuxiliares->obtenerCuentasAuxiliares();
    }
    
}