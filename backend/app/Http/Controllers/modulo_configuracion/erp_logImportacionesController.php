<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\IntegracionImportacion\IntengracionData;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Illuminate\Http\Request;

class erp_logImportacionesController extends Controller
{
    protected $servicesLogImportacion;



    public function __construct()
    {
        $this->servicesLogImportacion = new LogImportaciones;
        // $this->servicesLogImportacion = new IntengracionData;
    }



    public function show()
    {
        return $this->servicesLogImportacion->obtenerImportaciones();
    }
}