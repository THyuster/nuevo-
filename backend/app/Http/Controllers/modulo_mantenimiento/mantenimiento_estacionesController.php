<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloMantenimiento\Estaciones\IEstaciones;
use Illuminate\Http\Request;

class mantenimiento_estacionesController extends Controller
{

    private IEstaciones $_estaciones;

    public function __construct(IEstaciones $ie)
    {
        $this->_estaciones = $ie;
    }
    public function Crear(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
            'razon_social' => 'required|string',
            'nit' => 'required|integer',
            'municipio_id' => 'required|integer',
            'telefono' => 'required|string',
        ]);

        return $this->_estaciones->addIMantenimientoEstaciones($request->all());
    }

    public function Actualizar($id, Request $request)
    {
        
        // return "hola";

        $request->validate([
            'codigo' => 'nullable|string',
            'razon_social' => 'nullable|string',
            'nit' => 'nullable|integer',
            'municipio_id' => 'nullable|integer',
            'telefono' => 'nullable|string',
        ]);
        
        return $this->_estaciones->updateIMantenimientoEstaciones($id, $request->all());
    }

    public function Eliminar($id)
    {
        return $this->_estaciones->removeIMantenimientoEstaciones($id);
    }

    public function Estado($id)
    {
        return $this->_estaciones->EstadoIMantenimientoEstaciones($id);
    }

    public function Obtener()
    {
        return $this->_estaciones->getIMantenimientoEstaciones();
    }

}
