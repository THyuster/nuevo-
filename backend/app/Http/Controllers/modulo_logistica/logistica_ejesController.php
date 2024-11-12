<?php

namespace App\Http\Controllers\modulo_logistica;

use App\Http\Controllers\Controller;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloLogistica\ServicesEjes;
use Illuminate\Http\Request;

class logistica_ejesController extends Controller
{
    protected $repository, $servicesEjes, $nombreTable = "logistica_ejes";

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->servicesEjes = new ServicesEjes;

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
        return $this->servicesEjes->crearEjes($request->all());
    }

    public function show()
    {

        return $this->repository->sqlFunction("SELECT * FROM $this->nombreTable");
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules, $this->mensajes);
        return $this->servicesEjes->actualizarejes($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->servicesEjes->eliminarejes($id);
    }
}
