<?php

namespace App\Http\Controllers\modulo_contabilidad;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\moduloContabilidad\Centros\IContabilidadCentros;
use Illuminate\Http\Request;

class contabilidad_centrosController extends Controller
{

    private IContabilidadCentros $_centros;
    public function __construct(IContabilidadCentros $iContabilidadCentros)
    {
        $this->_centros = $iContabilidadCentros;
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
        return $this->_centros->getContabilidadCentros();
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_centros->addContabilidadCentros($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_centros->updateContabilidadCentros($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_centros->removeContabilidadCentros($id);
    }
    public function estado($id)
    {
        return $this->_centros->updateEstadoContabilidadCentros($id);
    }
}
