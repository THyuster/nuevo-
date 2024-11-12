<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloInventario\IServicioHomologaciones;
use App\Utils\TransfersData\ModuloInventario\Talla\ITallaInventario;
use Illuminate\Http\Request;

class inventarios_homologacionesController extends Controller
{
    private IServicioHomologaciones $_servicioHomologaciones;
    public function __construct(IServicioHomologaciones $iServicioHomologaciones)
    {
        $this->_servicioHomologaciones = $iServicioHomologaciones;
    }

    private $rules = [
        'codigo' => 'required',
        'descripcion' => 'required',
        'articulos' => 'required|array',
        'articuloPrincipal' => 'required',
    ];

    private $rulesUpdate = [
        'codigo' => 'nullable',
        'descripcion' => 'required'
    ];

    private $mesagge = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function obtener()
    {
        return $this->_servicioHomologaciones->obtenerHomologaciones();
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mesagge);
        return $this->_servicioHomologaciones->create($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mesagge);
        return $this->_servicioHomologaciones->update($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_servicioHomologaciones->delete($id);
    }
    public function estado($id)
    {
        return $this->_servicioHomologaciones->statusUpdate($id);
    }
}
