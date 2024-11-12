<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloMantenimiento\Mediciones\IMediciones;
use Illuminate\Http\Request;

class mantenimiento_medicionesController extends Controller
{
    protected IMediciones $_mediciones;
    public function __construct(IMediciones $m)
    {
        $this->_mediciones = $m;
    }

    public function obtener()
    {
        return $this->_mediciones->getMediciones();;
    }
    public function obtenerMedicionID($id)
    {
        return $this->_mediciones->getMedicionById($id);
    }
    public function crear(Request $request)
    {
        $request->validate([
            'equipo_id' => 'nullable|string',
            'vehiculo_id' => 'nullable|string',
            'fecha_registro'=> 'date',
            'observaciones' => 'required|string',
            'centro_trabajo' => 'required|string',
            'horometros.valor_horometro' => 'nullable|integer',
            'kilometros.valor_kilometros' => 'nullable|numeric',
            'combustible.cantidad_combustible' => 'nullable|numeric',
            'combustible.costo_por_unidad' => 'nullable|numeric',
            'combustible.proveedor' => 'nullable|string',
            'combustible.unidad' => 'nullable|numeric',
        ]);

        return $this->_mediciones->addMediciones($request->all());
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'equipo_id' => 'nullable|string',
            'vehiculo_id' => 'nullable|string',
            'observaciones' => 'required|string',
            'centro_trabajo' => 'required|integer',
            'horometros.valor_horometro' => 'nullable|integer',
            'kilometros.valor_kilometros' => 'nullable|numeric',
            'combustible.cantidad_combustible' => 'nullable|numeric',
            'combustible.costo_por_unidad' => 'nullable|numeric',
            'combustible.proveedor' => 'nullable|string',
            'combustible.unidad' => 'nullable|numeric',
        ]);
        return $this->_mediciones->updateMediciones($id, $request->all());
    }

    public function eliminar($id)
    {
        return $this->_mediciones->removeMediciones($id);
    }
}
