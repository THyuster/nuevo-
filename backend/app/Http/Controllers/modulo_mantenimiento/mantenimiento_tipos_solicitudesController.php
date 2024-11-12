<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloMantenimiento\CSolicitudes;
use App\Utils\Repository\RepositoryDynamicsCrud;
// use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesTiposSolicitudes;
use Illuminate\Http\Request;

class mantenimiento_tipos_solicitudesController extends Controller 
{
    private IServicesTiposSolicitudes $_servicesTiposSolicitudes;
    // private CSolicitudes $_cSolicitudes;

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

    public function __construct(IServicesTiposSolicitudes $iServicesTiposSolicitudes)
    {
        $this->_servicesTiposSolicitudes = $iServicesTiposSolicitudes;
    }

    public function index()
    {
        return view('modulo_mantenimiento.tipos_solicitudes.index');
    }

    public function create(Request $request)
    {
        $request->validate($this->rules,$this->mensagge);
        return $this->_servicesTiposSolicitudes->crearTipoSolicitud($request->all());
    }

    

    public function show()
    {
        return  $this->_servicesTiposSolicitudes->getTipoSolicitud();
    }

    public function update(int $id, Request $request)
    {
        

        $request->validate($this->rulesUpdate,$this->mensagge);
        return $this->_servicesTiposSolicitudes->actualizarTipoSolicitud($id, $request->all());
    }

    public function destroy(string $id)
    {
        return $this->_servicesTiposSolicitudes->eliminarTipoSolicitud($id);
    }
}
