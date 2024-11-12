<?php

namespace App\Http\Controllers\modulo_sagrilaft;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\Sagrilaft\Empleados\Services\ISagrilaftEmpleadoServiceColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{     
    private ISagrilaftEmpleadoServiceColor $iSagrilaftEmpleadoServiceColor;
    public function __construct(ISagrilaftEmpleadoServiceColor $iSagrilaftEmpleadoServiceColor) {
        $this->iSagrilaftEmpleadoServiceColor = $iSagrilaftEmpleadoServiceColor;
    }
    public function getAllColors (){
        return $this->iSagrilaftEmpleadoServiceColor->getAllColors();
    }

    public function getByIdColors(){
        return $this->iSagrilaftEmpleadoServiceColor->getByIdColors();
    }

    // public function createColor(Request $request) {
    //     $request->validate([
    //         'descripcion' => 'required|string|max:255', 
    //         'color' => 'required|string|max:255', 
    //     ]);

    //     $color = $this->iSagrilaftEmpleadoServiceColor->createColor();

    //     return response()->json([
    //         'message' => 'Color creado con éxito',
    //         'color' => $color
    //     ], 201);
    // }
}

