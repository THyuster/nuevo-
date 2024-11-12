<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class inventarios_registroMedicionesController extends Controller
{
    public function Obtener()
    {
        return [];
    }


    public function Crear(Request $request)
    {
        return $request;
    }

    public function Actualizar($id, Request $request)
    {
        return $request;
    }

    public function Eliminar($id)
    {
        return $id;
    }


}
