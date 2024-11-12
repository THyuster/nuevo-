<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloInventario\Departamentos\CDepartamentos;
use App\Utils\TransfersData\ModuloInventario\Departamentos\IDepartamentosInventario;
use Illuminate\Http\Request;

class inventarios_departamentosController extends Controller
{
    //
    private IDepartamentosInventario $_departamentos;
    public function __construct(IDepartamentosInventario $iDepartamentoInventarios)
    {
        $this->_departamentos = $iDepartamentoInventarios;
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
        return $this->_departamentos->getDepartamentosInventario();
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_departamentos->addDepartamentosInventario($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_departamentos->updateDepartamentosInventario($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_departamentos->removeDepartamentosInventario($id);
    }
    public function estado($id)
    {
        return $this->_departamentos->updateEstadoDepartamentosInventario($id);
    }    

}
