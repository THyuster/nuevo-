<?php

namespace App\Http\Controllers\modulo_nomina;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloNomina\IServiceEntidadesNomina;
use Illuminate\Http\Request;

class nomina_entidadesController extends Controller
{
    private IServiceEntidadesNomina $_serviceEntidadesNomina;

    private $rules = [
        'codigo' => 'required',
        'descripcion' => 'required',
        'nit' => 'required',
        'tipo_entidad_id' => 'required',
    ];

    private $rulesUpdate = [
        'codigo' => 'nullable',
        'descripcion' => 'nullable',
        'nit' => 'nullable',
        'tipo_entidad_id' => 'nullable',
    ];

    private $mensagge = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function __construct(IServiceEntidadesNomina $iServiceEntidadesNomina)
    {
        $this->_serviceEntidadesNomina = $iServiceEntidadesNomina;
    }
    public function crear(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_serviceEntidadesNomina->crearEntidad($request->all());
    }

    public function obtener()
    {
        return $this->_serviceEntidadesNomina->obtenerTodasEntidades();
    }

    public function actualizar(string $id, Request $request)
    {
        $request->validate($this->rulesUpdate, $this->mensagge);
        return $this->_serviceEntidadesNomina->actualizarEntidad($id, $request->all());
    }

    public function eliminar(string $id)
    {
        return $this->_serviceEntidadesNomina->eliminarEntidad($id);
    }


}
