<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloInventario\Color\IColorInventario;
use Illuminate\Http\Request;

class inventarios_colorController extends Controller
{
    protected  $_color;
    public function __construct(IColorInventario $iColorInventario)
    {
        $this->_color = $iColorInventario;
    }

    private $rules = [
        'codigo' => 'required',
        'descripcion' => 'required'
    ];

    private $mensagge = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function obtener()
    {
        return $this->_color->getColorInventario();
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_color->addColorInventario($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_color->updateColorInventario($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_color->removeColorInventario($id);
    }
    public function estado($id)
    {
        return $this->_color->updateEstadoColorInventario($id);
    }    
}
