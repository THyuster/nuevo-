<?php
namespace App\Http\Controllers\modulo_nomina;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloNomina\IServicesUserCentros;
use Illuminate\Http\Request;

class nomina_userCentrosController extends Controller
{
    private IServicesUserCentros $_iServicesUserCentros;

    private $rules = [
        'user_id' => 'required',
        'centro_id' => 'required'
    ];

    private $rulesUpdate = [
        'user_id' => 'required',
        'centro_id' => 'required'
    ];

    private $mensagge = [
        'required' => 'El campo :attribute es obligatorio.',
    ];

    public function __construct(IServicesUserCentros $iServicesUserCentros)
    {
        $this->_iServicesUserCentros = $iServicesUserCentros;
    }


    public function create(Request $request)
    {
        $request->validate($this->rules, $this->mensagge);
        return $this->_iServicesUserCentros->crearUserCentro($request->all());
    }

    public function show()
    {
        return $this->_iServicesUserCentros->getUserCentro();
    }

    public function update(int $id, Request $request)
    {
        $request->validate($this->rulesUpdate, $this->mensagge);
        return $this->_iServicesUserCentros->actualizarUserCentro($id, $request->all());
    }

    public function status(int $id): string
    {
        return $this->_iServicesUserCentros->estadoUserCentro($id);
    }

    public function destroy(string $id)
    {
        return $this->_iServicesUserCentros->eliminarUserCentro($id);
    }
}