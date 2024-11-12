<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesItemsDiagnostico;
use Illuminate\Http\Request;

class mantenimiento_ItemsDiagnosticoController extends Controller
{
    private IServicesItemsDiagnostico $_servicesItemsDiagnostico;

    private $rules = [
        "descripcion" => 'required',
        "tipo_clasificacion" => 'required',
        "tipo_orden_id" => 'required',
    ];

    private $rulesUpdate = [
        "descripcion" => 'required',
        "tipo_clasificacion" => 'required',
        "tipo_orden_id" => 'required',
    ];

    private $mensagge = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function __construct(IServicesItemsDiagnostico $iServicesItemsDiagnostico)
    {
        $this->_servicesItemsDiagnostico = $iServicesItemsDiagnostico;
    }

    public function create(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_servicesItemsDiagnostico->crearItemsDiagnostico($request->all());
    }

    public function show()
    {
        return $this->_servicesItemsDiagnostico->obtenerTodosItemsDiagnostico();
    }
    public function itemsConRespuesta()
    {
        return $this->_servicesItemsDiagnostico->obtenerTodosItemsDiagnosticoConRespuesta();
    }
    public function itemsConTipoOrden($idAsigActa, $idActa)
    {
        return $this->_servicesItemsDiagnostico->obtenerItemsTipoOrden($idAsigActa, $idActa);
    }

    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'id' => 'required',
        // ]);

        // return $request->all(); 
        $request->validate($this->rulesUpdate, $this->mensagge);
        return $this->_servicesItemsDiagnostico->actualizarItemsDiagnostico($request->all());
    }

    public function destroy(Request $request)
    {
        // $this->validate($request, [
        //     'id' => 'required',
        // ]);

        return $this->_servicesItemsDiagnostico->eliminarItemsDiagnostico($request->all());
    }
    public function updateStatus(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        return $this->_servicesItemsDiagnostico->actualizarEstadoItem($request->all());
    }
}