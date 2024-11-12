<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloInventario\Talla\ITallaInventario;
use Illuminate\Http\Request;

class inventarios_tallaController extends Controller
{
    private ITallaInventario $_talla;
    public function __construct(ITallaInventario $iTallaInventario)
    {
        $this->_talla = $iTallaInventario;
    }

    private $rules = [
        'codigo' => 'required',
        'descripcion' => 'required'
    ];

    private $rulesUpdate = [
        'codigo' => 'nullable',
        'descripcion' => 'required'
    ];

    private $mensagge = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function obtener()
    {
        return $this->_talla->getTallaInventario();
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_talla->addTallaInventario($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_talla->updateTallaInventario($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_talla->removeTallaInventario($id);
    }
    public function estado($id)
    {
        return $this->_talla->updateEstadoTallaInventario($id);
    }    
}
