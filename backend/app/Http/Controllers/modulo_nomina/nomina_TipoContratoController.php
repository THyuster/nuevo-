<?php

namespace App\Http\Controllers\modulo_nomina;

use App\Http\Controllers\Controller;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloNomina\ServicesTipoContrato;
use Illuminate\Http\Request;

class nomina_TipoContratoController extends Controller
{
    protected $repository, $servicesTipoContrato, $nombreTable = "logistica_tipo_contrato";

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->servicesTipoContrato = new ServicesTipoContrato;

    }
    private $mensajes = [
        'required' => 'El campo :attribute es obligatorio.'
    ];
    private $rules = [
        'codigo' => 'required',
        'descripcion' => 'required'
    ];

    public function create(Request $request)
    {
        $request->validate($this->rules, $this->mensajes);
        return $this->servicesTipoContrato->crearTipocontrato($request->all());
    }

    public function show()
    {

        return $this->repository->sqlFunction("SELECT * FROM $this->nombreTable");
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules, $this->mensajes);
        return $this->servicesTipoContrato->actualizarTipocontrato($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->servicesTipoContrato->eliminarTipocontrato($id);
    }
}
