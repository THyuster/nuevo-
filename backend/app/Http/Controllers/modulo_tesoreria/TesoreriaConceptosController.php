<?php

namespace App\Http\Controllers\modulo_tesoreria;

use App\Data\Dtos\ModuloTesoreria\TesoreriaConceptosDto;
use App\Data\Dtos\ModuloTesoreria\TesoreriaGruposConceptosDto;
use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloTesoreria\IServicioConceptos;
use App\Utils\TransfersData\ModuloTesoreria\IServicioGruposConceptos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TesoreriaConceptosController extends Controller
{

    private IServicioConceptos $iServicioConceptos;

    public function __construct(IServicioConceptos $iServicioConceptos) {
        $this->iServicioConceptos = $iServicioConceptos;
    }
    
    public function index() {
        return $this->iServicioConceptos->obtenerConceptos(true);
    }
    public function indexSinEncriptar() {
        return $this->iServicioConceptos->obtenerConceptos(false);
    }
    public function crear(Request $request)
    {
        $rules = $this->reglasValidacion();
         $validator = Validator::make( $rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
         if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $tesoreriaDto = TesoreriaConceptosDto::fromArray($request->all());
        return $this->iServicioConceptos->crearConceptos($tesoreriaDto);
    }

    public function actualizar(Request $request)
    {
        $tesoreriaDto = TesoreriaConceptosDto::fromArray($request->all());
        return $this->iServicioConceptos->actualizarConceptos($tesoreriaDto );
    }

    public function eliminar(String $id)
    {
        return $this->iServicioConceptos->eliminarConceptos($id);
    }
      private function reglasValidacion()
    {
        return
            [
                'id' => 'required|string',
                'nombre' => 'required|string',
                'descripcion' => 'required|string',
            ];
    }
}