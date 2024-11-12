<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloInventario\Linea\ILineaInventario;
use Illuminate\Http\Request;

class inventarios_lineaController extends Controller
{
    private ILineaInventario $_linea;
    public function __construct(ILineaInventario $iLineaInventario)
    {
        $this->_linea = $iLineaInventario;
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
        return $this->_linea->getLineaInventario();
    }

    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_linea->addLineaInventario($request->all());
    }
    public function actualizar($id, Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_linea->updateLineaInventario($id, $request->all());
    }
    public function eliminar($id)
    {
        return $this->_linea->removeLineaInventario($id);
    }
    public function estado($id)
    {
        return $this->_linea->updateEstadoLineaInventario($id);
    }    
}
