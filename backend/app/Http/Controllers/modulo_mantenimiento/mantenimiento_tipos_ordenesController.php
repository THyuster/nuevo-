<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesTiposOrdenes;
use Illuminate\Http\Request;

class mantenimiento_tipos_ordenesController extends Controller
{
    private IServicesTiposOrdenes $_servicesTiposOrdenes;


    private $rules = [
        'codigo' => 'required',
        'descripcion' => 'required',
    ];

    // private $rulesUpdate = [
    //     'codigo' => 'nullable',
    //     'descripcion' => 'required',
    //     'tipo_acta_modal' => 'required',
    // ];

    private $mensagge = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function __construct(IServicesTiposOrdenes $_servicesTiposOrdenes)
    {
        $this->_servicesTiposOrdenes = $_servicesTiposOrdenes;
    }

    public function index()
    {
        return view('modulo_mantenimiento.tipos_ordenes.index');
    }

    public function create(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_servicesTiposOrdenes->crearTipoOrden($request->all());
    }

    public function show()
    {
        return $this->_servicesTiposOrdenes->getTipoOrden();
    }


    public function update(Request $request, string $id)
    {
        return $this->_servicesTiposOrdenes->actualizarTipoOrden($id, $request->all());
    }


    public function destroy(string $id)
    {
        return $this->_servicesTiposOrdenes->eliminarTipoOrden($id);
    }
    public function updateStatus(string $id)
    {
        return $this->_servicesTiposOrdenes->actualizarEstado($id);
    }
}
