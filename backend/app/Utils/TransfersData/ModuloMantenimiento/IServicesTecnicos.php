<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use Illuminate\Http\Request;

interface IServicesTecnicos {
    public function crearTecnicos(Request $request);
    public function eliminarTecnicos(string $id);
    public function getTecnicosAll();
    public function GetTecnicosSSR($filter);
    public function estadoTecnicos(int $id);
    public function GetTecnicosSSRByIdOrden($id);
}
