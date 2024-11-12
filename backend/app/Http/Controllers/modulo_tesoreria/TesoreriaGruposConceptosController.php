<?php

namespace App\Http\Controllers\modulo_tesoreria;

use App\Data\Dtos\ModuloTesoreria\TesoreriaGruposConceptosDto;
use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloTesoreria\IServicioGruposConceptos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TesoreriaGruposConceptosController extends Controller
{

    private IServicioGruposConceptos $iServicioConceptos;

    public function __construct(IServicioGruposConceptos $iServicioConceptos) {
        $this->iServicioConceptos = $iServicioConceptos;
    }
    public function index() {
        return $this->iServicioConceptos->obtenerGrupoConceptos();
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
        $tesoreriaDto = TesoreriaGruposConceptosDto::fromArray($request->all());
        return $this->iServicioConceptos->crearGrupoConceptos($tesoreriaDto);
    }

    public function actualizar(Request $request)
    {
        $tesoreriaDto = TesoreriaGruposConceptosDto::fromArray($request->all());
        return $this->iServicioConceptos->actualizarGrupoConceptos($tesoreriaDto );
    }

    public function eliminar(String $id)
    {
        return $this->iServicioConceptos->eliminarGrupoConceptos($id);
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