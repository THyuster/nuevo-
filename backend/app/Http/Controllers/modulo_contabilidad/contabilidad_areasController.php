<?php

namespace App\Http\Controllers\modulo_contabilidad;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\moduloContabilidad\Areas\IContabilidadAreas;
use Illuminate\Http\Request;

class contabilidad_areasController extends Controller
{
    private IContabilidadAreas $_areas;
    public function __construct(IContabilidadAreas $iContabilidadAreas)
    {
        $this->_areas = $iContabilidadAreas;
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
        return $this->_areas->getContabilidadAreas();
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_areas->addContabilidadAreas($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_areas->updateContabilidadAreas($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_areas->removeContabilidadAreas($id);
    }
    public function estado($id)
    {
        return $this->_areas->updateEstadoContabilidadAreas($id);
    }
}
