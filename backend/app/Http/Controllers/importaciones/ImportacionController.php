<?php

namespace App\Http\Controllers\importaciones;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\IntegracionImportacion\IntengracionData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImportacionController extends Controller
{
    protected $servicesLogImportacion;

    public function __construct()
    {
        $this->servicesLogImportacion = new IntengracionData;
    }

    public function registrarImportacion(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [
            'required' => 'el campo :attribute es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return $this->servicesLogImportacion->validacionDeOpciones($request->all());
    }
    private function getValidationRules()
    {
        return [
            'idOdbc' => 'required|int',
            'modulos' => 'required|array'
        ];
    }
}