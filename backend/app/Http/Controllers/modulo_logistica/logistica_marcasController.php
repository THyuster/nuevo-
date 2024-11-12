<?php

namespace App\Http\Controllers\modulo_logistica;

use App\Data\Dtos\Logistica\Marcas\Request\MarcasRequestCreateDTO;
use App\Http\Controllers\Controller;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas\IMarcas;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class logistica_marcasController extends Controller
{

    private IMarcas $_marcas;

    public function __construct(IMarcas $iMarcas)
    {
        $this->_marcas = $iMarcas;
    }

    public function Crear(Request $request)
    {
        $marcasRequestCreateDTO = new MarcasRequestCreateDTO($request->all());
        if (!$marcasRequestCreateDTO->descripcion) {
            throw new Exception("Rellene la informacion", Response::HTTP_NOT_FOUND);
        }
        return $this->_marcas->crearMarcas($marcasRequestCreateDTO);
    }
    public function Obtener()
    {
        return $this->_marcas->getMarcas();
    }
    public function ObtenerDesencrypt()
    {
        return $this->_marcas->getMarcas(2);
    }

    public function Actualizar(Request $request, $id)
    {
        $id = EncryptionFunction::StaticDesencriptacion(base64_decode($id));
        $marcasRequestCreateDTO = new MarcasRequestCreateDTO($request->all());
        if (!$marcasRequestCreateDTO->descripcion) {
            throw new Exception("Rellene la informacion", Response::HTTP_NOT_FOUND);
        }
        $marcasRequestCreateDTO->id = $id;
        $this->_marcas->actualizarMarcas($marcasRequestCreateDTO);
        return response()->json(true);
    }

    public function delete($id)
    {
        $id = EncryptionFunction::StaticDesencriptacion(base64_decode($id));
        return $this->_marcas->delete($id);
    }

}
