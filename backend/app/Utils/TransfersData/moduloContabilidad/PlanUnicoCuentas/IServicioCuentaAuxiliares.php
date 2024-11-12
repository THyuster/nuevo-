<?php
namespace App\Utils\TransfersData\moduloContabilidad\PlanUnicoCuentas;

interface IServicioCuentaAuxiliares{
    public function obtenerCuentasAuxiliares();   
    public function buscarCuentaAuxiliarPorId(String $id);   
}