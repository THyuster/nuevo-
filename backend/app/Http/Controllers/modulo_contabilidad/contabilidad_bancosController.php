<?php

namespace App\Http\Controllers\modulo_contabilidad;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\moduloContabilidad\Bancos\IContabilidadBancos;
use Illuminate\Http\Request;

class contabilidad_bancosController extends Controller
{
    private IcontabilidadBancos $_bancos;
    public function __construct(IContabilidadBancos $icontabilidadBancos)
    {
        $this->_bancos = $icontabilidadBancos;
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
        return $this->_bancos->getcontabilidadBancos();
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_bancos->addcontabilidadBancos($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_bancos->updatecontabilidadBancos($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_bancos->removecontabilidadBancos($id);
    }
    public function estado($id)
    {
        return $this->_bancos->updateEstadocontabilidadBancos($id);
    }
    public function conversionDatosTns()
    {
        return $this->_bancos->conversionBancosTnsAErp();
    }
}