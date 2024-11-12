<?php

namespace App\Http\Controllers\modulo_logistica;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloLogistica\IServiceTrailers;
use Illuminate\Http\Request;

class logistica_trailersController extends Controller
{
    private IServiceTrailers $_serviceTrailer;
    public function __construct(IServiceTrailers $iserviceTrailer)
    {
        $this->_serviceTrailer = $iserviceTrailer;
    }
    public function index()
    {
        return view("modulo_logistica.trailers.index");
    }
    public function create(Request $request) : string
    {
        $request->validate([
            "codigo" => 'required',
            "descripcion" => 'required'
        ]);
        
        $entidadTrailer = $request->all();
        return $this->_serviceTrailer->crearTrailer($entidadTrailer);
    }

    public function show()
    {
        return $this->_serviceTrailer->getTrailer();
    }

    public function update(Request $request, int $id) : string
    {
        $request->validate([
            "codigo" => '',
            "descripcion" => ''
        ]);
        
        $entidadTrailer = $request->all();
        return $this->_serviceTrailer->actualizarTrailer($id,$entidadTrailer);
    }
    public function destroy(int $id) : string
    {
        return $this->_serviceTrailer->eliminarTrailer($id);
    }
}