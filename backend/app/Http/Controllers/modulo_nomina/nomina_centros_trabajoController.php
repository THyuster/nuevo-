<?php
namespace App\Http\Controllers\modulo_nomina;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloNomina\IServicesCentrosTrabajo;
use Illuminate\Http\Request;

class nomina_centros_trabajoController extends Controller
{
    private IServicesCentrosTrabajo $_servicesCentrosTrabajo;

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

    public function __construct(IServicesCentrosTrabajo $iServicesCentrosTrabajo)
    {
        $this->_servicesCentrosTrabajo = $iServicesCentrosTrabajo;
    }

    public function index()
    {
        return view('modulo_nomina.centro_trabajo.index');
    }

    public function create(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_servicesCentrosTrabajo->crearCentroTrabajo($request->all());
    }

    public function show()
    {
        return  $this->_servicesCentrosTrabajo->getCentroTrabajo();
    }

    public function update(int $id, Request $request)
    {
        $request->validate($this->rulesUpdate, $this->mensagge);
        return $this->_servicesCentrosTrabajo->actualizarCentroTrabajo($id, $request->all());
    }

    public function status(int $id) : string {
        return $this->_servicesCentrosTrabajo->estadoCentroTrabajo($id);
    }

    public function destroy(string $id)
    {
        return $this->_servicesCentrosTrabajo->eliminarCentroTrabajo($id);
    }
}