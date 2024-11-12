<?php

namespace App\Http\Controllers\modulo_logistica;

use App\Http\Controllers\Controller;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloLogistica\ServicesBlindajes;
use Illuminate\Http\Request;

class logistica_blindajesController extends Controller
{
    protected $repository, $servicesBlindajes, $nombreTable = "logistica_blindajes";

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->servicesBlindajes = new ServicesBlindajes;

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
        return $this->servicesBlindajes->crearBlindajes($request->all());
    }

    public function show()
    {

        return $this->repository->sqlFunction("SELECT * FROM $this->nombreTable");
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules, $this->mensajes);
        return $this->servicesBlindajes->actualizarBlindajes($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->servicesBlindajes->eliminarBlindajes($id);
    }
}
