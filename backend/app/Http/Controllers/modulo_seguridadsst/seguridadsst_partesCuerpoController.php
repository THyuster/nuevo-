<?php

namespace App\Http\Controllers\modulo_seguridadsst;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloSeguridadSst\PartesCuerpo\ISeguridadSstPartesCuerpo;
use Illuminate\Http\Request;

class seguridadsst_partesCuerpoController extends Controller
{
    private ISeguridadSstPartesCuerpo $_partesCuerpo;
   
    public function __construct(ISeguridadSstPartesCuerpo $seguridadSstPartesCuerpo)
    {
        $this->_partesCuerpo = $seguridadSstPartesCuerpo;
    }

    private $rules = [
        'codigo' => 'required',
        'descripcion' => 'required'
    ];

    private $rulesUpdate = [
        'codigo' => 'required',
        //'nullable',
        'descripcion' => 'required'
    ];

    private $mensagge = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function obtener()
    {
        return $this->_partesCuerpo->getseguridadsstPartesCuerpo();
        //return "hola";
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_partesCuerpo->addseguridadsstPartesCuerpo($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_partesCuerpo->updateseguridadsstPartesCuerpo($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_partesCuerpo->removeseguridadsstPartesCuerpo($id);
    }
    public function estado($id)
    {
        return $this->_partesCuerpo->updateEstadoseguridadsstPartesCuerpo($id);
    }
}
